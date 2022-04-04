<?php

namespace App\Controllers;

class Politicas extends BaseController
{
   
    public function __construct()
    {
       
    }

	public function index($rowno = 0)
	{
	}

	public function facebook()
	{
		$this->showHeader();
		$this->ShowContent('facebook');
		$this->showFooter();
	}

	public function delfacebook()
	{
		header('Content-Type: application/json');

		$signed_request = $_POST['signed_request'];
		$data = $this->parse_signed_request($signed_request);
		$user_id = $data['user_id'];

		// Start data deletion

		$status_url = 'https://punored.com/Politicas/deletion?id='.uniqid(); // URL to track the deletion
		$confirmation_code = uniqid(); // unique code for the deletion request

		$data = array(
			'url' => $status_url,
			'confirmation_code' => $confirmation_code
		);
		echo json_encode($data);
	}

	public function deletion(){
		echo "borrado";
	}
	function parse_signed_request($signed_request)
	{
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		$secret = "61e9a105c5fceaf5a11ed7ba14650547"; // Use your app secret here

		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);

		// confirm the signature
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			error_log('Bad Signed JSON signature!');
			return null;
		}

		return $data;
	}

	function base64_url_decode($input)
	{
		return base64_decode(strtr($input, '-_', '+/'));
	}
}
