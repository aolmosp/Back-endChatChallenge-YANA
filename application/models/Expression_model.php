<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expression_model extends CI_Model {
	protected static  $TABLE = "expression"; 
    protected static  $KEY   = "exp_id";
    
    private $collumns = array(
        'exp_id'        => 0,
        'exp_qst_id'    => 0,
        'exp_text'      =>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    public function findById($id)
	{
		$query = $this->db->get_where(self::$TABLE, array(self::$KEY => $id));
		if($query->num_rows() == 1){
            $this->setCollumns($query->row_object());
		}
	}

}