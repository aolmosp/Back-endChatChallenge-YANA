<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
    }

    public function login_post(){
        $name = $this->input->post('usr_name');
        $pass = $this->input->post('usr_pass');
        isset($name) && isset($pass) ?: $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'login failed', 'token' => ''], RestController::HTTP_UNAUTHORIZED );
        $this->load->model('User_model','user',true);
        $this->user->login($name, $pass)    ?
                                                $this->response( ['status' => RestController::HTTP_OK ,'message' => 'login ok', 'token' => 'GENERATE_TOKEN'], RestController::HTTP_OK ) 
                                            :
                                                $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'login failed', 'token' => ''], RestController::HTTP_UNAUTHORIZED );

    }

}