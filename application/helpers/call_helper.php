<?php

function api_otp_verify($params)
{
   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://sms.telnyx.com/messages");
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Accept: application/json",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: application/json",
      "cache-control: no-cache",
      "x-profile-secret: u5slTZzvtPpKFbvjXCafmzkB"
   ]);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $json = curl_exec($ch);

   curl_close($ch);

   return _output($json);
}

function send_otp($mobile)
{
   ini_set('display_errors', 1);
   $CI = &get_instance();

   // OTP Insert in OTP table
   $otp_no = rand('100000', '999999');
   $created_at = date('Y-m-d H:i:s');
   $valid_upto = date('Y-m-d H:i:s', strtotime('+3 minutes'));

   $data = [
      'mobile' => $mobile,
      'otp' => $otp_no,
      'created_at' =>  $created_at,
      'valid_upto' => $valid_upto,
   ];
   $CI->db->insert('otp', $data);

   // Sending SMS
   $message = "Dear customer, Your authentication OTP is " . $otp_no . ". Please do not share OTP. It is valid upto " . $valid_upto . " - Regards, Diraleads";

   $params = [
      'from' => TELNYX_SENDER_ID,
      // 'to' => '+91'.$mobile,
      'to' => '+1' . $mobile,
      'body' => $message
   ];

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://sms.telnyx.com/messages");
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Accept: application/json",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: application/json",
      "cache-control: no-cache",
      "x-profile-secret: " . TELNYX_PROFILE_SECRET
   ]);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $json = curl_exec($ch);
   curl_close($ch);

   $response = _output($json);
   if (isset($response->success) && ($response->success == false)) {
      return $response;
   } else {
      // SMS Logs
      $arr = [
         'mobile_no' => $mobile,
         'request' => json_encode($params),
         'message' => $message,
         'location' => 'Login - OTP',
         'response' => $json,
      ];
      $CI->db->insert('logs_sms', $arr);
      return $response;
   }
}

function send_sms($mobile, $message)
{
   ini_set('display_errors', 1);
   $CI = &get_instance();

   $params = [
      'connection_id' =>  TEXML_APP_ID,
      'from' => TELNYX_SENDER_ID,
      'to' => '+91' . $mobile
   ];

   $ch = curl_init();


   //    curl -X POST \
   //   --header "Content-Type: application/json" \
   //   --header "Accept: application/json" \
   //   --header "Authorization: Bearer YOUR_API_KEY" \
   //   --data '{"connection_id": "uuid", "to": "+18005550199", "from": "+18005550100"}' \


   curl_setopt($ch, CURLOPT_URL, "https://api.telnyx.com/v2/calls");
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Accept: application/json",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: application/json",
      "cache-control: no-cache",
      "Authorization: Bearer " . TELNYX_API_KEY
   ]);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $json = curl_exec($ch);
   curl_close($ch);

   $response = _output($json);
   if (isset($response->success) && ($response->success == false)) {
      return $response;
   } else {
      // SMS Logs
      $arr = [
         'mobile_no' => $mobile,
         'request' => json_encode($params),
         'message' => $message,
         'location' => 'SMS - Notify',
         'response' => $json,
      ];
      $CI->db->insert('logs_sms', $arr);
      return $response;
   }
}

/**
 * Sending SMS Notification
 */
function send_notify_sms($mobile, $message)
{
   $CI = &get_instance();

   $params = [
      'from' => TELNYX_SENDER_ID,
      // 'to' => '+91'.$mobile,
      // 'to' => '+1'.$mobile,
      'to' => $mobile,
      'body' => $message
   ];

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://sms.telnyx.com/messages");
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Accept: application/json",
      "Cache-Control: no-cache",
      "Connection: keep-alive",
      "Content-Type: application/json",
      "cache-control: no-cache",
      "x-profile-secret: " . TELNYX_PROFILE_SECRET
   ]);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $json = curl_exec($ch);
   curl_close($ch);

   $response = _output($json);
   if (isset($response->success) && ($response->success == false)) {
      return $response;
   } else {
      return $json;
   }
}

function get_vn()
{

   $params = [
      'search_type' => 2,
      // 'to' => '+91'.$mobile,
      // 'to' => '+1'.$mobile,
      'limit' => 10,
      'search_descriptor' => [
         'country_iso' => "us",
         'state' => "NY",
      ]
   ];

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://api.telnyx.com/origination/number_searches");
   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Accept: application/json",
      "Content-Type: application/json",
      "x-api-token: rgzYekljThirucLyvKhPoQ",
      "x-api-user: info@diraleads.com"
   ]);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $json = curl_exec($ch);
   curl_close($ch);

   $response = _output($json);
   if (isset($response->success) && ($response->success == false)) {
      return $response;
   } else {
      return $json;
   }
}

function _output($json)
{
   return json_decode($json);
}
