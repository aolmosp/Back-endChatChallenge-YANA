<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->library('grocery_CRUD');
    }

    public function login_post(){
        $name = $this->security->xss_clean($this->input->post('usr_name'));
        $pass = $this->security->xss_clean($this->input->post('usr_pass'));
        isset($name) && isset($pass) ?: $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'login failed', 'token' => ''], RestController::HTTP_UNAUTHORIZED );
        $this->load->model('User_model','user',true);
        $this->user->login($name, $pass) ? $this->response( ['status' => RestController::HTTP_OK ,'message' => 'login ok', 'token' => 'GENERATE_TOKEN'], RestController::HTTP_OK ) : $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'login failed', 'token' => ''], RestController::HTTP_UNAUTHORIZED );
    }

    //CREATE USERS FROM API - BACKOFFICE IS AVAILABLE FOR ADMINS
    public function create_post(){
        $name = $this->security->xss_clean($this->input->post('usr_name'));
        $pass = $this->security->xss_clean($this->input->post('usr_pass'));
        $email = $this->security->xss_clean($this->input->post('usr_pass'));
        isset($name) && isset($pass) && isset($name) ?: $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'create failed'], RestController::HTTP_UNAUTHORIZED );
        $this->load->model('User_model','user',true);
        $user = $this->user->create([ 'usr_name'  => $name,
                                      'usr_pass'  => $pass,
                                      'usr_email' => $email
                                    ]);
        $user->save() ? $this->response( ['status' => RestController::HTTP_OK ,'message' => 'create ok', 'token' => 'GENERATE_TOKEN'], RestController::HTTP_OK ) : $this->response( ['status' => RestController::HTTP_UNAUTHORIZED ,'message' => 'create failed'], RestController::HTTP_UNAUTHORIZED );

    }
    
    public function receiver_post(){
        $usr_id = $this->security->xss_clean($this->input->post('usr_id'));
        $msg = $this->security->xss_clean($this->input->post('usr_msg'));
        $this->load->model('Conversation_model', 'conversation', TRUE);
        $response = $this->conversation->generateMessage($usr_id, $msg);

        $this->response( [
                            'status' => RestController::HTTP_OK ,
                            'expression' => $response['expression'],
                            'greeting' => $response['greeting'],
                            'question' => $response['question'],
                            'answer' => $response['answer'],
                        ], RestController::HTTP_OK );
    }

}