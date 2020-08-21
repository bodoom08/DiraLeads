<?php
class Email_enquiry extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
  }

  public function send_contact_email()
  {
    // error_reporting(E_ALL);
    // ini_set('display_errors', 'on');

    $this->load->helper('email_helper');

    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('phone', 'Mobile', 'required|trim|numeric|exact_length[10]');
    // $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
    $this->form_validation->set_rules('send_message', 'Message', 'required|trim');

    // if ($this->form_validation->run()) {
    // $to = 'aniruddha.roy12061990@gmail.com';
    $to = ACCOUNT_TO_EMAIL;
    $from = $this->input->post('email');
    // $subject = $this->input->post('subject');
    $subject = '';
    $name  = $this->input->post('name');
    $email  = $this->input->post('email');
    $phone  = $this->input->post('phone');
    $send_message  = $this->input->post('send_message');

    $body = "Name: " . $this->input->post('name') . "<br/>";
    $body .= "Email: " . $this->input->post('email') . "<br/>";
    $body .= "Phone: " . $this->input->post('phone') . "<br/>";
    $body .= "Message: " . $this->input->post('send_message') . "<br/>";



    // Contact template
    $body = '<table style="background:#f9f9f9; padding: 30px 20px; width: 100%;">
          <tr>
            <td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Enquiry</td>
          </tr>
          <tr>
            <td style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">You have received a new message from the enquiries, the credentials are follows</td>
          </tr>
          <tr>
            <td align="center">
              <table style="padding: 8px 20px; color: #50504f; font-size: 18px; background: #c6f3b7; line-height: 18px; width: 65%;">
                <tr >
                  <td style="text-align:left; padding:10px 20px 20px 0px; width:10%;">Name</td>
                  <td style="width:9%"> : </td>
                  <td style="text-align: left; padding: 10px 20px 20px 0px; color: #50504f; font-style: italic; width:70%;">' . $name . '</td>
                </tr>
                <tr >
                  <td style="text-align:left; padding:10px 20px 20px 0px; width:10%;">Email</td>
                  <td style="width:9%"> : </td>
                  <td style="text-align: left; padding: 10px 20px 20px 0px; color: #50504f; font-style: italic; width:70%;">' . $email . '</td>
                </tr>
                <tr >
                  <td style="text-align:left; padding:10px 20px 20px 0px; width:10%;">Phone</td>
                  <td style="width:9%"> : </td>
                  <td style="text-align: left; padding: 10px 20px 20px 0px; color: #50504f; font-style: italic; width:70%;">' . $phone . '</td>
                </tr>
                <tr >
                  <td style="text-align:left; padding:10px 20px 20px 0px; width:10%;">Message</td>
                  <td style="width:9%"> : </td>
                  <td style="text-align: left; padding: 10px 20px 20px 0px; color: #50504f; font-style: italic; width:70%;">' . $send_message . '</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>';


    $status = send_enq_email($from, $to, $subject, $body);
    die(json_encode(['success' => true, 'error' => $status]));
    // } else {
    //   die(json_encode(['success' => false, 'error' => $this->form_validation->error_string()]));
    // }
  }

  public function email_subscribe()
  {
    $this->load->helper('email_helper');

    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

    if ($this->form_validation->run()) {
      // $to = 'aniruddha.roy12061990@gmail.com';
      $to = ACCOUNT_TO_EMAIL;
      $from = $this->input->post('email');

      /*
              Check the email previously in the database or not
              */
      $data = [
        'email_id' => $this->input->post('email')
      ];
      $this->db->where('email_id', $this->input->post('email'));
      $result = $this->db->get('subscribers');
      if ($result->num_rows() > 0) {
        die(json_encode(['success' => false, 'error' => '<p>You are already subscribed. Thank you.</p>']));
      }


      $subject = "Email Subscription";

      // EMAIL subscription template
      $body = '<table style="background:#f9f9f9; padding: 30px 20px;">
              <tr>
                <td class="h2-center" style="color:#000000; font-size:32px; line-height:36px; text-align:center; padding-bottom:20px;">Email Subscription</td>
              </tr>
              <tr>
                <td style="color:#5d5c5c; font-size:14px; line-height:22px; text-align:center; padding-bottom:22px;">Thank you for signing up. You will be the first to know about news and update, stay tuned...</td>
              </tr>
              </table>';

      $status = send_enq_email($from, $to, $subject, $body);

      // Insert the data into the database
      $data = [
        'email_id' => $this->input->post('email')
      ];
      $this->db->insert('subscribers', $data);

      die(json_encode(['success' => true, 'message' => '<p><strong>Thank you for signing up. You will be the first to know about news and update, stay tuned...</strong></p>']));
    } else
      die(json_encode(['success' => false, 'error' => $this->form_validation->error_string()]));
  }
}
