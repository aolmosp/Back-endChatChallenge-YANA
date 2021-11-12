<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {
	protected static  $TABLE = "user"; 
    private $collumns = array(
        'usr_id'=>0,
        'usr_name'=>'',
        'usr_pass'=>'',
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
}