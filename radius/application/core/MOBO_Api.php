<?php

class MOBO_Api extends CI_Controller
{
    protected $user = null;
    protected function _json($data, $code = 200, $text = 'OK')
    {
        $this->output
            ->set_status_header($code, $text)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    protected function _checkAuth()
    {
        $token = $this->input->get_request_header('Authorization');
        $authUser = $this->db->where('api_key', substr($token, 7))
            ->where('status', 'active')->get('users')->row();

        if ($authUser) {
            $this->user = $authUser;
        } else {
            $this->_json("Api token mismatch!", 422);
        }
    }
}
