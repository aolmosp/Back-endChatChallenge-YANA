<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	protected static  $TABLE = "user"; 
    protected static  $KEY   = "usr_id"; 

    private $collumns = array(
        'usr_id'=>0,
        'usr_name'=>'',
        'usr_pass'=>'',
        'usr_email'=>'',
        );

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function login($user , $pass)
    {
        $this->load->library('encryption');
        $res  = $this->db->get_where(self::$TABLE, array('usr_name' => $user ));
        if ($res->num_rows() == 1) {
            $row = $res->row_object();
            return $this->encryption->decrypt($row->usr_pass) == $pass ? true : false;
        }else{
            return false;
        }
    }

    public function create($row = null)
    { 
        $v = new User_model();
        !isset($row) ?: $v->setCollumns($row);
        return $v;
    }

    public function setCollumns($data)
    {
        foreach ($data as $key => $value) {
            $this->collumns[$key] = $value;
        }
    }

    public function save(){
        if($this->collumns[Self::$KEY] == 0){
            $this->load->library('encryption');
            $this->collumns['usr_pass'] = $this->encryption->encrypt($this->collumns['usr_pass']);
            $this->db->insert(self::$TABLE, $this->collumns);
            $this->collumns[Self::$KEY] = $this->db->insert_id();
            return true;
        }else{
            unset($this->collumns['usr_pass']);
            $this->db->where(Self::$KEY, $this->collumns[Self::$KEY]);
            $this->db->update(self::$TABLE, $this->collumns);
            return true;
        }
        return false;
    }

    public function backoffice()
    {
        $this->load->library('grocery_CRUD');

        $crud = new grocery_CRUD();
        $crud->set_table(self::$TABLE);
        $crud->callback_before_insert(array($this,'encrypt_password_callback'));
        $crud->callback_before_update(array($this,'encrypt_password_callback'));
        $output = $crud->render();

        return $output;
    }

    function encrypt_password_callback($post_array, $primary_key = null) {
        $this->load->library('encryption');

        if(!empty($post_array['usr_pass'])){
            $post_array['usr_pass'] = $this->encryption->encrypt($post_array['usr_pass']);
        }else{
            unset($post_array['usr_pass']);
        }
      
        return $post_array;
    }

}