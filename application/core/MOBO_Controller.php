<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MOBO_Controller extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $user_type = $_SESSION['user_type'] ?? 'public';

        define('IS_USER', ($user_type == 'user'));
    }

    protected function userOnly()
    {
        if(!constant('IS_USER')) {
            redirect('login?ref=' . urlencode(current_url()));
        }
    }
}
