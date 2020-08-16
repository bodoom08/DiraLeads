<?php
function searchNumbersHelper($country_iso, $state, $limit = 5)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.telnyx.com/origination/number_searches",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\r\n  \"search_descriptor\": {\r\n    \"country_iso\": \"$country_iso\",\r\n    \"state\": \"$state\"\r\n  },\r\n\"limit\" :$limit\r\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return _outputjson($response);
}

function createNumberOrdersHelper($number)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.telnyx.com/origination/number_orders",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\n    \"requested_numbers\": [\n        \"$number\"\n    ],\n    \"requested_inexplicit_numbers\": []\n}",
		CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"x-api-token: " . TEL_API_TOKEN,
			"x-api-user: " . TEL_API_USER,
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return _outputjson($response);
}

function myNumbersHelper($number)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.telnyx.com/origination/numbers/" . $number,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"Accept: application/json",
			"x-api-token: " . TEL_API_TOKEN,
			"x-api-user: " . TEL_API_USER,
			"Content-Type: application/json"
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return _outputjson($response);
}

function _outputjson($json)
{
	return json_decode($json, true);
}
