<?php

use yidas\queue\worker\Controller as WorkerController;

class JobWorker extends WorkerController
{
    protected function init()
    {
        $this->load->library('JobQueue');
    }

    protected function handleWork()
    {
        $jobs = $this->jobqueue->getJobs();

        if (!$jobs || count($jobs) == 0) 
            return false;

        $this->jobqueue->processJob($jobs);

        return true;
    }

    protected function handleListen() 
    {
        $flag = $this->jobqueue->exists();
        if ($flag)
            return $this->handleWork();
        return false;
    }
}