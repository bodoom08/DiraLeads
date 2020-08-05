<?php

class MOBO_User extends CI_Controller
{
    public function __construct() {
        parent::__construct();

        $user_type = $_SESSION['user_type'] ?? 'public';

        define('IS_ADMIN', ($user_type == 'admin'));
        
        define('IS_AGENT', ($user_type == 'agent'));
    }

    protected function only($user_types)
    {
        if(is_string($user_types) && $this->checkConst($user_types)) {
            redirect('login');
        }
        
        if(is_array($user_types)) {
            foreach ($user_types as $i => $user_type) {
                if($this->checkConst($user_type)) {
                    unset($user_types[$i]);
                    continue;
                } else {
                    break;
                }
            }

            if(count($user_types) == 0) {
                redirect('login');
            }
        }
    }

    private function checkConst(string $user_type)
    {
        return !constant('IS_'.strtoupper($user_type));
    }
}
