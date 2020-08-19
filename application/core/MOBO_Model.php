<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MOBO_Model extends CI_Model {
	private $_path = API_ENDPOINT;
	
	function __get($key)
	{
		$this->_path .= $key;
		return $this;
	}

	private function curl_set_opt(&$ch, $postData = null){
		$headers = [
			'accept: application/json',
			'Content-Type: application/json'
		];
		if(!empty($_SESSION['jwt'])) {
			$token = $_SESSION['jwt'];
			array_push($headers, 'Authrization: Bearer ' . $token);
		}

		$opts = [
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_HTTPHEADER => $headers
			
		];
		if($postData) {
			$opts += [
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => json_encode($postData)
			];
		}
		
		curl_setopt_array($ch, $opts);
	}

	function get($id = '')
	{
		$ch = curl_init(implode('/', [$this->_path, $id]));

		$this->curl_set_opt($ch);

		$response = json_decode(curl_exec($ch));
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);

		return array($response, $status);
	}

	function _register($data, $provider = 'local')
	{
		$ch = curl_init(implode('/', [$this->_path, $provider,'register']));
		$this->curl_set_opt($ch, $data);

		$response = json_decode(curl_exec($ch));
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$err = curl_error($ch);
		curl_close($ch);

		return array($response, $status);
	}
}
