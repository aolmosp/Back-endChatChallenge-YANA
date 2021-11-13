<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index(){
        $this->load->view('backoffice/index');
    }

    public function users(){
        $this->load->model('User_model','user',true);
        $this->load->view('backoffice/index', (array)$this->user->backoffice());
    }

    public function answers(){
        $this->load->model('Answer_model','answer',true);
        $this->load->view('backoffice/index', (array)$this->answer->backoffice());
    }

    public function expressions(){
        $this->load->model('Expression_model','expression',true);
        $this->load->view('backoffice/index', (array)$this->expression->backoffice());
    }

    public function questions(){
        $this->load->model('Question_model','question',true);
        $this->load->view('backoffice/index', (array)$this->question->backoffice());
    }

    public function greetings(){
        $this->load->model('Greeting_model','greeting',true);
        $this->load->view('backoffice/index', (array)$this->greeting->backoffice());
    }
    
}