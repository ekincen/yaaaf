<?php
/*
*  
*  YAF FRAMEWORK version 2.2.7
* 
* --------------------------------------------------------------------
*  Description
* --------------------------------------------------------------------
*
*  @author ekin.cen <yijian.cen@gmail.com>
*  
*  @copyright  Copyright (c)  2012 - ekin studio
*  
*/
class SinaController extends System_Controller_Public{

	protected $_app_key;

	protected $_app_secret;

	protected $_callback_url;

	protected function _initialize(){
		header('Content-type: text/html; charset=utf-8');
		//import sae class file
		Yaf_loader::import("Vendor/WeiboSDK.php");
		//get the app config 
		$config=new Yaf_Config_Ini(CONF_PATH.'connect.ini', 'sina');
		$this->_app_key=$config->appKey;
		$this->_app_secret=$config->appSecret;
		$this->_callback_url=$config->callbackUrl;
	}


	public function authAction(){
		$o = new SaeTOAuthV2($this->_app_key,$this->_app_secret);
		$code_url = $o->getAuthorizeURL($this->_callback_url);
		$this->redirect($code_url);
	}

	public function loginAction(){
		$o = new SaeTOAuthV2($this->_app_key,$this->_app_secret);
		// var_dump($this->getModel('Test_model'));
		YAF_Session::getInstance()->set('identity','test'); 
		$this->redirect('/');

		// if (isset($_REQUEST['code'])) {
		// 	$keys = array();
		// 	$keys['code'] = $_REQUEST['code'];
		// 	$keys['redirect_uri'] = WB_CALLBACK_URL;
		// 	try {
		// 		$token = $o->getAccessToken( 'code', $keys ) ;
		// 	} catch (OAuthException $e) {
		// 	}
		// }

		// if ($token) {
		// 	$_SESSION['token'] = $token;
		// 	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );

		// echo '授权完成,<a href="weibolist.php">进入你的微博列表页面</a><br />';
		// } else {

		// 	echo '授权失败。';
		// }


	}

	public function logout(){

	}
}
/* End of file */