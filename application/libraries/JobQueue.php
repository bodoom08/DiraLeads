<?php 

class JobQueue 
{
    public function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('M_property');

        log_message('info', 'starting worker....');
    }

    public function getJobs()
    {
        return $this->CI->M_property->getJobs();
    }

    public function processJob($jobs)
    {
        try {
            foreach($jobs as $job) 
            {
                echo ($job['property_id'] . ' - ' . $job['subscriber_id']);
                $this->CI->M_property->deleteJob($job['id']);
            }
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function exists()
    {
        return $this->CI->M_property->existJob();
    }
}