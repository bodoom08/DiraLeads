<?php

function send_email($to, $subject, $body)
{
    $ci=& get_instance();
    
    $ci->load->library('email');
    
    // $config['useragent'] = RADIUS;
    // $config['mailtype'] = 'html';

    $from = 'info@diraleads.tk';

    $config = Array(
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
    
    if(!$status)
    {
        $error = $ci->email->print_debugger();
    }

    $ci->db->insert('email_logs', compact('to', 'subject', 'body', 'status', 'error'));

    return $status;
}

function user_reg_email($to, $subject, $href) {
    // Password template
    $body = '<table style="background:#f9f9f9; padding: 30px 20px;">
        <tr>
            <td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">User Email Verification</td>
        </tr>
        <tr>
            <td style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">To set a new password Click on the reset button. If you unable to click, manually go to this url <a href='.$href.'>'.$href.'</a></td>
        </tr>
        <tr>
            <td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Welcome to Diraleads!</td>
        </tr>
        <tr>
            <td class="text-center" style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">Please click the link to verify</td>
        </tr>
        <tr>
            <td align="center">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="text-button-orange" style="background:#e85711; color:#ffffff; font-size:14px; line-height:18px; text-align:center; padding:10px 30px; border-radius:20px;"><a href='.$href.' target="_blank" class="link-white" style="color:#ffffff; text-decoration:none;"><span class="link-white" style="color:#ffffff; text-decoration:none;">Verify</span></a></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
    send_email($to, $subject, $body);
}