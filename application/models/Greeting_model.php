<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Greeting_model extends CI_Model {
	protected static  $TABLE = "greeting"; 
    protected static  $KEY   = "grt_id";

    private $collumns = array(
        'grt_id'        => 0,
        'grt_qst_id'    => 0,
        'grt_text'      =>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function set_grt($id)
    {
        $this->db->select('*');
        $this->db->from(Self::$TABLE);
        $this->db->where(Self::$KEY, $id);
        $this->db->limit(1);
        $this->setCollumns($this->db->get()->row_object());               
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

    public function backoffice()
    {
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table(self::$TABLE);
        $crud->set_relation('grt_qst_id','question','qst_id');
        $output = $crud->render();
        return $output;
    }
}