<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Welcome extends RestController {

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }
	
	public function users_get()
	{
		$this->response( [
			'status' => false,
			'message' => 'No such user found'
		], 404 );
	}
}
