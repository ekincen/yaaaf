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
class QqController extends System_Controller_Public{

	protected $_app_id;

	protected $_app_key;

	protected $_callback_url;

	protected $_scope;

	protected function _initialize(){
		//get the app config 
		$config=new Yaf_Config_Ini(CONF_PATH.'connect.ini', 'qq');
		$this->_app_id=$config->appId;
		$this->_app_key=$config->appKey;
		$this->_callback_url=$config->callbackUrl;
		$this->_scope=$config->scope;
	}

	public function authAction(){

// $_SESSION["appkey"]   = $this->_app_key;

	    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
	    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
	    . $this->_app_id . "&redirect_uri=" . urlencode($this->_callback_url)
	    . "&state=" . $_SESSION['state']
	    . "&scope=".$this->_scope;

	    $this->redirect($login_url);
	}

	public function loginAction(){
		echo 'yes';
	}
}
/* End of file */