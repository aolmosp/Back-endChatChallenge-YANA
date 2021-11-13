<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Conversation_model extends CI_Model {
	protected static  $TABLE = "conversation"; 
    protected static  $KEY   = "cnv_id";
    protected static  $FOREING_KEY   = "cnv_usr_id"; 

    private $collumns = array(
        'cnv_id'          => 0,
        'cnv_usr_id'      => 0,
        'cnv_last_msg'    => '',
        'cnv_text'         => '',
        'cnv_last_update' => '',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Question_model');
        $this->load->model('Greeting_model');
        $this->load->model('Expression_model');
        $this->load->model('Answer_model');
        
    }
    
    public function generateMessage($usr_id, $msg){
        $cnv = $this->get_cnv($usr_id);

        if($cnv->num_rows() == 1){

            $cnv = $cnv->row_object();
            $last_msg = explode("_", $cnv->cnv_last_msg);

            $now = new DateTime();
            $last_interaction = new DateTime($cnv->cnv_last_update);

            //REINICIA LA CONVERSACIÓN AL SOBREPASAR LOS 2 MINUTOS DESDE LA ÚLTIMA INTERACCIÓN
            if($now->diff($last_interaction)->format('%i') >= 2){
                $greeting = new Greeting_model();
                $greeting->set_grt(2);
                $question = new Question_model();
                $question->set_qst($greeting->get('grt_qst_id'));
                
                $cnv = new Conversation_model();
                $cnv->set('cnv_usr_id', $usr_id);
                $cnv->set('cnv_last_msg', "question_".$question->get('qst_id'));
                $cnv->set('cnv_last_update', date('Y-m-d H:i:s'));
                $cnv->save();

                return [
                    'expression' => null,
                    'greeting' => $greeting->get('grt_text'),
                    'question' => $question->get('qst_text'),
                    'answer' => null,
                ];
            }

            switch($last_msg[0]){

                case 'question':
                        $question = new Question_model();
                        $question->findById($last_msg[1]);
                        $expression = new Expression_model();
                        $expression->findById($question->get('qst_exp_id'));
                        $question->findById($expression->get('exp_qst_id'));
                        $answer = $question->findAnswers();
                        $cnv = new Conversation_model();
                        $cnv->set('cnv_usr_id', $usr_id);
                        is_null($answer) ? $cnv->set('cnv_last_msg', "question_".$question->get('qst_id')) : $cnv->set('cnv_last_msg', "answer_".$question->get('qst_id'));
                        $cnv->set('cnv_last_update', date('Y-m-d H:i:s'));
                        $cnv->save();
                        
                        return [
                            'expression' => str_replace("[replace]", $msg, $expression->get('exp_text') ),
                            'greeting' => '',
                            'question' => $question->get('qst_text'),
                            'answer' => $answer,
                        ];

                    break;
                case 'answer':

                        $answer = new Answer_model();
                        $answer->findById($msg);
                        $expression = new Expression_model();
                        $expression->findById($answer->get('ans_exp_id'));
                        $question = new Question_model();
                        $question->findById($expression->get('exp_qst_id'));
                        $answer = $question->findAnswers();

                        $cnv = new Conversation_model();
                        $cnv->set('cnv_usr_id', $usr_id);
                        is_null($answer) ? $cnv->set('cnv_last_msg', "question_".$question->get('qst_id')) : $cnv->set('cnv_last_msg', "answer_".$question->get('qst_id'));
                        $cnv->set('cnv_last_update', date('Y-m-d H:i:s'));
                        $cnv->save();

                        return  [
                            'expression' => str_replace("[replace]", $msg, $expression->get('exp_text') ),
                            'greeting' => '',
                            'question' => $question->get('qst_text'),
                            'answer' => $answer,
                        ];

                    break;
            }
        }else{
            $greeting = new Greeting_model();
            $greeting->set_grt(1);
            $question = new Question_model();
            $question->set_qst($greeting->get('grt_qst_id'));
            
            $cnv = new Conversation_model();
            $cnv->set('cnv_usr_id', $usr_id);
            $cnv->set('cnv_last_msg', "question_".$question->get('qst_id'));
            $cnv->set('cnv_last_update', date('Y-m-d H:i:s'));
            $cnv->save();

            return [
                'expression' => null,
                'greeting' => $greeting->get('grt_text'),
                'question' => $question->get('qst_text'),
                'answer' => null,
            ];

        }
    }

    function get_cnv($usr_id){
        $this->db->select('*');
        $this->db->from(Self::$TABLE);
        $this->db->where(Self::$FOREING_KEY, $usr_id);
        $this->db->order_by('cnv_last_update', 'desc');
        $this->db->limit(1);
        return $this->db->get();
    }

    function set($attr, $val){
		if(isset($this->collumns[$attr])){
			$this->collumns[$attr] = $val;
		}
		return  "";
	}

    public function save(){
        if($this->collumns[Self::$KEY] == 0){
            $this->db->insert(self::$TABLE, $this->collumns);
            $this->collumns[Self::$KEY] = $this->db->insert_id();
            return true;
        }else{
            $this->db->where(Self::$KEY, $this->collumns[Self::$KEY]);
            $this->db->update(self::$TABLE, $this->collumns);
            return true;
        }
        return false;
    }

}