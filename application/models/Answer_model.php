<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Answer_model extends CI_Model {
	protected static  $TABLE = "answer"; 
    protected static  $KEY   = "ans_id";
    
    private $collumns = array(
        'ans_id'        => 0,
        'ans_qst_id'    => 0,
        'ans_exp_id'    => 0,
        'ans_text'      =>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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
}