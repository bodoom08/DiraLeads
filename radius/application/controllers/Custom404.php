<?php
defined('BASEPATH') or exit('No direct script access is allowed');
class custom404 extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	function index() {
		echo 'custom404';
	}
}