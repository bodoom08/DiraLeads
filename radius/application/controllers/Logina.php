<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logina extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		
	}

	function __call($method, $arguments) {
		die($method);
	}
	
	public function test() {
		echo "kjdsabh";
	}
}
