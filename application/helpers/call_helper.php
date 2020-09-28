<?php

function make_outbound_call($number)
{
   ini_set('display_errors', 1);
   $CI = &get_instance();

   $params = [
      'From' => "+15167570663",
      'To' => $number,
      'url' => base_url() . 'webhook/subscriber_receive'
   ];

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://api.telnyx.com/v2/texml/calls/" . TEXML_DEV_APP_ID);
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
   $response = json_decode($json);

   return $response;
}
