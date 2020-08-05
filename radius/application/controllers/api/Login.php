<?php

require APPPATH . 'core/MOBO_Api.php';

class Login extends MOBO_Api
{
    function index()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db
            ->select('id, name, email, mobile, subscribe_flag')
            ->where('email', $email)
            ->where('status', 'active')
            ->where('password', sha1($password))
            ->get('users')
            ->row();

        if ($user) {
            $token = $this->_generate_key();

            $this->db->update('users', ['api_key' => $token], ['id' => $user->id]);

            $this->_json(compact('token', 'user'));
        } else {
            $this->_json('Wrong username or password', 422);
        }
    }

    private function _generate_key($length = 29)
    {
        do {
            // Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

            // If an error occurred, then fall back to the previous method
            if ($salt === FALSE) {
                $salt = hash('sha256', time() . mt_rand());
            }
            $new_key = substr($salt, 0, $length);
        } while ($this->_key_exists($new_key));
        return $new_key;
    }

    private function _key_exists($key)
    {
        return $this->db
            ->where('api_key', $key)
            ->count_all_results('users') > 0;
    }
}
