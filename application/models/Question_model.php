<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Question_model extends CI_Model {
	protected static  $TABLE = "question"; 
    protected static  $KEY   = "qst_id";
    
    private $collumns = array(
        'qst_id'       => 0,
        'qst_group'    => 0,
        'qst_exp_id'   => 0,
        'qst_text'     =>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function set_qst($id, $group = null)
    {
        $this->db->select('*');
        $this->db->from(Self::$TABLE);
        $this->db->where(Self::$KEY, $id);
        $this->db->limit(1);
        $this->setCollumns($this->db->get()->row_object());
    }

    private function setCollumns($data)
    {
        foreach ($data as $key => $value) {
            $this->collumns[$key] = $value;
        }
    }

    public function get($attr){
		if(isset($this->collumns[$attr])){
			return $this->collumns[$attr];
		}
		return  "";
	}

    public function findById($id)
	{
		$query = $this->db->get_where(self::$TABLE, array(self::$KEY => $id));
		if($query->num_rows() == 1){
            $this->setCollumns($query->row_object());
		}
	}

    public function findAnswers(){
        $query = $this->db->select('ans_id , ans_text')->from('answer')->where('ans_qst_id', $this->collumns[Self::$KEY])->get();
        if($query->num_rows() > 0){
            foreach ($query->result() as $key => $value) {
                $answers[] = (array) $value;
            }
            return $answers;
        }
        return null;
    }

    
    public function backoffice()
    {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table(self::$TABLE);
        $output = $crud->render();
        return $output;
    }

}