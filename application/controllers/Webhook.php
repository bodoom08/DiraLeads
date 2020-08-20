<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');
require_once(APPPATH . 'third_party/vendor/telnyx/telnyx-php/init.php');

use Twilio\TwiML\VoiceResponse;
// use Telnyx;

class Webhook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('M_property');
        \Telnyx\Telnyx::setApiKey(TELNYX_API_KEY);

        session_destroy();
    }

    function sms_receive()
    {
        $requests = $this->input->post();
        $this->load->helper('file');



        $data = json_encode($requests);
        if (!write_file(FCPATH . 'webhook.txt', $data, 'a')) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }

        \Telnyx\Message::Create([
            "from" => "+15166361518", // Your Telnyx number
            "to" => "+17606165259",
            "text" => "Hello, World!"
        ]);
    }

    public function email($token)
    {
        $token = explode(':', base64_decode(urldecode($token)));

        $this->db->where('token', $token[1]);

        switch ($token[0]) {
            case 'agent':
                $this->db->from('agents');
                break;
            default:
                $this->db->from('users');
                break;
        }

        $user = $this->db
            ->select('id, name, email, mobile')
            ->get()
            ->row_array();

        if (is_null($user)) {
            show_404();
        } else {
            if (
                $this->input->method() == 'post'
                && ($this->input->post('password')
                    === $this->input->post('cnf_password'))
            ) {
                $this->db->where('token', $token[1]);
                $this->db->set('token', null);
                $this->db->set('password', sha1($this->input->post('password')));
                $this->db->update('users');
                redirect('login');
            } else {
                if (($this->input->method() == 'post') && ($this->input->post('password')
                    != $this->input->post('cnf_password')))
                    $error = "Password Not matched";
                else if (($this->input->method() == 'post') && ($this->input->post('password') == '' || $this->input->post('cnf_password') == ''))
                    $error = "Password Required";
                $this->load->view('new_password', compact('error'));
            }
        }
    }

    public function incoming_call() // manage all incoming calls from customers
    {

        $requests = $this->input->post();

        $data = json_encode($requests);

        // return $this->output
        //     ->set_content_type('application/json')
        //     ->set_status_header(200)
        //     ->set_output($data);

        // $write_data = json_encode($requests);
        // if (!write_file(FCPATH . 'webhook.txt', $write_data, 'a')) {
        //     echo 'Unable to write the file';
        // } else {
        //     echo 'File written!';
        // }

        //find the rental owner's number from database
        // $virtual_number = '+15162198991';
        $virtual_number = $requests['To'];
        $result = $this->db->select('*')
            ->from('virtual_numbers')
            ->where('virtual_numbers.number', $virtual_number)
            ->join('properties', 'properties.vn_id = virtual_numbers.id', 'left')
            ->join('users', 'users.id = properties.user_id', 'left')
            ->get()->result_array();

        $owner_number = $result[0]['country_code'] . $result[0]['mobile'];

        // $this->load->helper('file');
        // $write_data = json_encode($result[0]);
        // if (!write_file(FCPATH . 'webhook.txt', $write_data, 'a')) {
        //     echo 'Unable to write the file';
        // } else {
        //     echo 'File written!';
        // }

        $voiceRes = new VoiceResponse();

        $isOwnerAvailable = true;

        // $voiceRes->say("Thanks for choosing DiraLeads, we are now connecting you with the rental's owner");
        // $voiceRes->play('https://api.twilio.com/cowbell.mp3', ['loop' => 1]);
        // $roomName = "diraLeads2020";

        // $dial = $voiceRes->dial('');
        // $dial->number(
        //     '+14062781888',
        //     [
        //         'statusCallbackEvent' => 'answered',
        //         'statusCallback' => base_url() . 'webhook/call_receive',
        //         'statusCallbackMethod' => 'POST'
        //     ]
        // );

        //Make a response for the incoming call
        if ($isOwnerAvailable) {
            $voiceRes->say("Thanks for choosing DiraLeads, we are now connecting you with the rental's owner");

            $roomName = "diraLeads2020";

            $dial = $voiceRes->dial('');
            $dial->number(
                $owner_number,
                [
                    'statusCallbackEvent' => 'answered',
                    'statusCallback' => base_url() . 'webhook/call_receive',
                    'statusCallbackMethod' => 'POST'
                ]
            );
        } else {
            $voiceRes->say("The rental owner is not available now, please try to call him when he is available");
        }

        // $dial->conference(
        //     $roomName,
        //     [
        //         // 'waitUrl' => 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient',
        //         'maxParticipants' => 2,
        //         // 'record' => 'record-from-start'
        //         // 'statusCallback' => "https://api.safeup.co/v1/getStatusConference",
        //     ]
        // );

        //return response to Telnyx
        return $this->output
            ->set_content_type('text/xml')
            ->set_output($voiceRes);
    }

    public function call_receive() // manage actions when the customer receives outbounding calls
    {
        $requests = $this->input->post();

        // $data = json_encode($requests);

        // return $this->output
        //     ->set_content_type('application/json')
        //     ->set_status_header(200)
        //     ->set_output($data);

        $this->load->helper('file');
        $data = json_encode($requests);
        if (!write_file(FCPATH . 'webhook.txt', $data, 'a')) {
            // echo 'Unable to write the file';
        } else {
            // echo 'File written!';
        }

        $voiceRes = new VoiceResponse();

        $voiceRes->play('https://api.twilio.com/cowbell.mp3', ['loop' => 1]);
        // $voiceRes->say("this is a caller from DiraLeads");

        // $dial = $voiceRes->dial('');

        // $roomName = "diraLeads2020";
        // $dial->conference(
        //     $roomName,
        //     [
        //         // 'waitUrl' => 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient',
        //         'maxParticipants' => 2,
        //         // 'record' => 'record-from-start'
        //         // 'statusCallback' => "https://api.safeup.co/v1/getStatusConference",
        //     ]
        // );

        return $this->output
            ->set_content_type('text/xml')
            ->set_output($voiceRes);
    }
}
