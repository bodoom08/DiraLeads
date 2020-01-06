<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . 'core/MOBO_User.php';
class Database extends MOBO_User
{
    public function __construct() {
        parent::__construct();

        if(!isset($_SESSION['id']))
            redirect(site_url('/'));
            
        $this->only(['agent', 'admin']);
        $this->load->model('M_users');
    }

    // public function _remap($method) {
    //     if($method == 'index') {
    //         $this->index();
    //     } else {
    //         redirect('custom404');
    //     }
    // }

    function index() {
        $path='/var/www/diraleads-com/dbbkup';
        $this->load->helper('directory');
        $map = directory_map($path, 1);
        $this->load->view('bkupdb',compact('map'));
    }

    function bkup() {
        resirect('database');
        $this->load->view('bkupdb');
    }

    function _dobkup() {
        // $this->load->dbutil();
        // $prefs = array(     
        //     'format'      => 'zip',             
        //     'filename'    => 'my_db_backup.sql'
        //     );


        // $backup =& $this->dbutil->backup($prefs); 

        // $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
        // $save = './upload/'.$db_name;

        // $this->load->helper('file');
        // write_file($save, $backup); 


        // $this->load->helper('download');
        // force_download($db_name, $backup);
        // $this->load->view('bkupdb');


        

    }

    function dobkup() {
        $filename='database_backup_'.date('G_a_m_d_y').'.sql';

        $result=exec('mysqldump diraleads --password=*675#Mob#Cod.Ddira --user=root --single-transaction >/var/www/'.$filename,$output);

        var_dump($output);

        if($output==''){/* no output is good */}
        else {/* we have something to log the output here*/}
    }

    function deletefile() {
        extract($_POST);
        unlink('/var/www/diraleads-com/dbbkup/'.$filename);
        die(json_encode(['type' => 'success', 'text' => 'File Deleted Successfully']));
    }
}