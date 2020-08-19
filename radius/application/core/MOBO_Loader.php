<?php defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');
use Jenssegers\Blade\Blade;

class MOBO_Loader extends CI_Loader {
    public function __construct() {
        parent::__construct();
        $this->blade = new Blade(APPPATH.'views', APPPATH.'cache/views');
    }

    public function view($view, $vars = [], $return = false)
    {
        if(file_exists(APPPATH . 'views/' . $view . '.blade.php')) {
            echo $this->blade->make($view, $vars)->render();
        } else {
            parent::view($view, $vars, $return);
        }
    }
}