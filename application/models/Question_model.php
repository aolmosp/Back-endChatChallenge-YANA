<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Question_model extends CI_Model {
	protected static  $TABLE = "question"; 
    protected static  $KEY   = "qst_id";
    
    private $collumns = array(
        'qst_id'        => 0,
        'qst_group_id'    => 0,
        'qst_exp_id'      =>'',
        'qst_ans_id'      =>'',
        'qst_text'      =>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function set_qst($random = true, $id, $group = null)
    {
        if($random){

        }else{
            $this->db->select('*');
            $this->db->from(Self::$TABLE);
            $this->db->where(Self::$KEY, $id);
            $this->db->limit(1);
            $this->setCollumns($this->db->get()->row_object());            
        }

    }

    function setCollumns($data)
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

}