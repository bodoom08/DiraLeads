<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Twilio\TwiML\VoiceResponse;

class Webhook extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        session_destroy();
    }

    function sms_receive()
    {
        $requests = $this->input->get();
        $this->load->helper('file');

        $data = json_encode($requests);
        if (!write_file(FCPATH . 'webhook.txt', $data, 'a')) {
            echo 'Unable to write the file';
        } else {
            echo 'File written!';
        }
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

        // $requests = $this->input->post();

        // $data = json_encode($requests);

        // return $this->output
        //     ->set_content_type('application/json')
        //     ->set_status_header(200)
        //     ->set_output($data);

        $voiceRes = new VoiceResponse();

        $voiceRes->say("Thanks for choosing DiraLeads, we are now connecting you with the rental's owner");
        // $voiceRes->play('https://api.twilio.com/cowbell.mp3', ['loop' => 1]);
        $roomName = "diraLeads2020";

        $dial = $voiceRes->dial('');
        $dial->number(
            '+17606165259',
            [
                'statusCallbackEvent' => 'initiated ringing answered completed',
                'statusCallback' => base_url() . 'webhook/call_receive',
                'statusCallbackMethod' => 'POST'
            ]
        );

        $dial->conference(
            $roomName,
            [
                // 'waitUrl' => 'http://twimlets.com/holdmusic?Bucket=com.twilio.music.ambient',
                'maxParticipants' => 2,
                // 'record' => 'record-from-start'
                // 'statusCallback' => "https://api.safeup.co/v1/getStatusConference",
            ]
        );

        return $this->output
            ->set_content_type('text/xml')
            ->set_output($voiceRes);
    }

    public function call_receive() // manage actions when the customer receives outbounding calls
    {
        $voiceRes = new VoiceResponse();

        $voiceRes->say("this is a caller from DiraLeads");

        return $this->output
            ->set_content_type('text/xml')
            ->set_output($voiceRes);
    }
}
