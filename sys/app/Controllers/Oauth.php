<?php

namespace App\Controllers;

date_default_timezone_set('UTC');
require APPPATH . 'ThirdParty/' . 'Facebook/Facebook.php';
define('FACEBOOK_SDK_V4_SRC_DIR', APPPATH . 'ThirdParty/' . '/Facebook/');
require_once APPPATH . 'ThirdParty/' . '/Facebook/autoload.php';

use Facebook;


require_once APPPATH . 'ThirdParty/' . 'Google/Google_Client.php';
require_once APPPATH . 'ThirdParty/' . 'Google/contrib/Google_Oauth2Service.php';


class Oauth extends BaseController
{

	function facebook()
	{
		//***** Facebook Client Configuration
		$facebook = new Facebook\Facebook(array(
			'app_id' => FB_APP_ID,
			'app_secret' => FB_APP_SECRET,
			'default_graph_version' => 'v2.5'
		));

		$helper = $facebook->getRedirectLoginHelper();
		$permissions = ['email']; // optional
		$url = $helper->getLoginUrl(base_url(FB_LOGIN_URL), $permissions);
		return redirect()->to($url); 
	}

	function iniciar($email, $foto, $nombres, $apellidos = '')
	{
		$id = "";
		$row = $this->db->query("SELECT * FROM usuario WHERE usua_email='{$email}'")->getRow();
		$ip = $this->request->getIPAddress();
		if (!isset($row->usua_id)) {
			$password = md5('dejfkkdkdk39393dfjk..');
			$data = array('usua_email' => $email, 'usua_nombres' => $nombres, 'usua_apellidos' => $apellidos, 'usua_password' => $password, 'usua_tipo_id' => '2');
			$this->db->table('usuario')->insert($data);
			$id = $this->db->insertID();

			$path = 'img_' . $id . '.small.jpg';

			if (copy($foto, APPPATH.'../../uploads/usuario/' . $path)) {
				$this->db->table('usuario')->update(array('usua_foto' => $path), array('usua_id' => $id));
			}
			$row = $this->db->query("SELECT * FROM usuario WHERE usua_id='{$id}'")->getRow();
		} else {
			$id = $row->usua_id;
		}
		$sesdata = array(
			'id'  => $id,
			'user'  => $nombres,
			'type'     => $row->usua_tipo_id,
			'auth'     => true
		);
		$session = session(); 
		$session->set($sesdata);
		$sql = "UPDATE usuario SET usua_lastip='{$ip}' WHERE usua_id='{$id}'";
		$this->db->query($sql);
		return redirect()->to(base_url()); 
	}

	function face()
	{
		 
		$facebook = new Facebook\Facebook(array(
			'app_id' => FB_APP_ID,
			'app_secret' => FB_APP_SECRET,
			'default_graph_version' => 'v2.5'
		));

		$helper = $facebook->getRedirectLoginHelper();
		
		try {
			$accessToken = $helper->getAccessToken();
			$facebook->setDefaultAccessToken($accessToken);
			$response = $facebook->get('me?locale=en_US&fields=name,first_name,last_name,email');
			$responsePicture = $facebook->get('/me/picture?redirect=false&height=300'); //getting user picture
			$userPicture = $responsePicture->getGraphUser();
			$userProfile = $response->getGraphUser();
			
			return $this->iniciar($userProfile["email"], $userPicture["url"], $userProfile["first_name"], $userProfile["last_name"]);
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
	}

	function google()
	{
		$gClient = new \Google_Client();
		$gClient->setApplicationName('Titulo');
		$gClient->setClientId(GP_CLIENT_ID);
		$gClient->setClientSecret(GP_CLIENT_SECRET);
		$gClient->setRedirectUri(base_url(GP_REDIRECT_URL) );
		$google_oauthV2 = new \Google_Oauth2Service($gClient);
		$url = $gClient->createAuthUrl();
		return redirect()->to($url); 
	}

	function goo()
	{
		die("code0");
		$gClient = new \Google_Client();
		
		$gClient->setApplicationName('Titulo');
		$gClient->setClientId(GP_CLIENT_ID);
		$gClient->setClientSecret(GP_CLIENT_SECRET);
		$gClient->setRedirectUri(base_url(GP_REDIRECT_URL));
		
		$google_oauthV2 = new \Google_Oauth2Service($gClient);

		$session = session(); 
		if ($this->request->getGet('code')) {
			die("code1");
			$gClient->authenticate();
			$session->set('token', $gClient->getAccessToken());
			return redirect()->to(base_url(GP_REDIRECT_URL));
		}

		$token = $session->get('token');
		if (!empty($token)) {
			die("code2");
			$gClient->setAccessToken($token);
		}

		if ($gClient->getAccessToken()) {
			die("code3");
			$userProfile = $google_oauthV2->userinfo->get();
			return $this->iniciar($userProfile['email'], $userProfile['picture'], $userProfile['given_name'], $userProfile['family_name']);
		} else {
			die("code4");
			$data['authUrl'] = $gClient->createAuthUrl();
			//die($gClient->createAuthUrl());
			//return redirect()->to($gClient->createAuthUrl());
		}
	}
}