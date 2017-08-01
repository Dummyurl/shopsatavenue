<?php
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH . '/third_party/php-jwt/JWT.php');
include_once(APPPATH . '/third_party/php-jwt/ExpiredException.php');
include_once(APPPATH . '/third_party/php-jwt/BeforeValidException.php');
include_once(APPPATH . '/third_party/php-jwt/SignatureInvalidException.php');

class Token_provider
{
	//The signing key
	//Can be generated with base64_encode(openssl_random_pseudo_bytes(64));
	private $secret_key = 'AbiJoj7IRI50ZZz9/xL2bp0+gPCY2RLqnOEa3mfx8jytjXQ7ZhFczxIAGWdHsUjYVDbJmQvuxOtjerjsqeF6Gw==';
	
	//Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
	private $encryption_algorithm = 'HS512';
	
	private $server_name;
	
	public function __construct()
    {
		$server_name = site_url();
    }
	
	/**
	* @param $expiry_duration in minutes
	*/
	public function getToken($user_id, $user_name, $expiry_duration = 60)
	{
		$token_id    = base64_encode(mcrypt_create_iv(32));
		$issued_at   = time();
		$not_before  = $issued_at + 0;       	//Adding 10 seconds
		$expire     = $not_before + $expiry_duration*60;      	// Adding 60 seconds
		
		//Create the token as an array
		$data = [
			'iat'  => $issued_at,         		// Issued at: time when the token was generated
			'jti'  => $token_id,          		// Json Token Id: an unique identifier for the token
			'iss'  => $this->server_name,       // Issuer
			'nbf'  => $not_before,        		// Not before
			'exp'  => $expire,           		// Expire
			'data' => [                  		// Data related to the signer user
				'userId'   => $user_id, 		// userid from the users table
				'userName' => $user_name, 		// User name
			]
		];
		
		$jwt = JWT::encode(
				$data,
				base64_decode($this->secret_key), 				
				$this->encryption_algorithm    				
			);
		
		return array('token'=>$jwt, 'expiry'=>$expire);
	}
	
	public function parseToken($token)
	{
		$result = JWT::decode($token, base64_decode($this->secret_key), array($this->encryption_algorithm));
		return $result;
	}


	
}
