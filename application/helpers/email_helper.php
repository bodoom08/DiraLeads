<?php

function send_email($to, $subject, $body)
{
    $ci = &get_instance();

    $ci->load->library('email');

    // $config['useragent'] = CFG_TITLE;
    // $config['mailtype'] = 'html';
    //$to = 'mobotics.aniruddha@gmail.com';
    $from = 'info@diraleads.tk';

    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp-relay.sendinblue.com',
        'smtp_port' => 587,
        'smtp_user' => '012yyh@gmail.com',
        'smtp_pass' => '8vWUJOPZS2Gdt7mF',
        // 'useragent' => CFG_TITLE,
        'mailtype'  => 'html',
        'wordwrap' => TRUE,
        'charset'   => 'utf-8'
    );

    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from($from);
    $ci->email->to($to);
    $ci->email->subject($subject);
    $ci->email->message($body);

    $status = $ci->email->send();

    if (!$status) {
        $error = $ci->email->print_debugger();
    }

    $ci->db->insert('email_logs', compact('to', 'subject', 'body', 'status', 'error'));

    return $status;
}

function send_enq_email($from = 'noreply@email.com', $to, $subject, $body)
{
    $ci = &get_instance();

    $ci->load->library('email');

    // $config['useragent'] = CFG_TITLE;
    // $config['mailtype'] = 'html';

    // $to = 'aniruddha.roy12061990@gmail.com';
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp-relay.sendinblue.com',
        'smtp_port' => 587,
        'smtp_user' => '012yyh@gmail.com',
        'smtp_pass' => '8vWUJOPZS2Gdt7mF',
        'useragent' => CFG_TITLE,
        'mailtype'  => 'html',
        'charset'   => 'iso-8859-1'
    );

    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    // $ci->email->from($from);
    $ci->email->from($from);
    $ci->email->to($to);
    $ci->email->subject($subject);
    $ci->email->message($body);

    $status = $ci->email->send();

    $error = null;

    if (!$status) {
        $error = $ci->email->print_debugger();
    }

    $ci->db->insert('email_logs', compact('to', 'subject', 'body', 'status', 'error'));

    return $status;
}
