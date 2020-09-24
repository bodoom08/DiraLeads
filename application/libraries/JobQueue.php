<?php
require(APPPATH . 'third_party/vendor/autoload.php');
require_once(APPPATH . 'third_party/vendor/telnyx/telnyx-php/init.php');

use Twilio\TwiML\VoiceResponse;
use Twilio\TwiML\MessagingResponse;

class JobQueue
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('M_property');
        // $this->CI->load->model('M_users');

        // \Telnyx\Telnyx::setApiKey(TELNYX_API_KEY);

        log_message('info', 'starting worker....');
    }

    public function getJobs()
    {
        return $this->CI->M_property->getJobs();
    }

    public function processJob($jobs)
    {
        try {
            foreach ($jobs as $job) {
                echo ($job['property_id'] . ' - ' . $job['subscriber_id']);
                // $subscriber = $this->db->select('country_code, mobile')
                //     ->from('users')
                //     ->where('id', $job['user_id'])
                //     ->get()->row();
                // $number = $subscriber['country_code'] . $subscriber['mobile'];

                // \Telnyx\Call::Create([
                //     "from" => "+15166361518", // Your Telnyx number
                //     "to" => $number,
                //     [
                //         'url' => base_url() . 'webhook/subscriber_receive',
                //     ]
                // ]);


                $this->CI->M_property->deleteJob($job['id']);
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function exists()
    {
        return $this->CI->M_property->existJob();
    }
}
