<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function users(){
        
        $this->load->model('User_model','user',true);
        $this->load->view('backoffice/users', (array)$this->user->backoffice());

    }

}