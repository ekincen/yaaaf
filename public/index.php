<?php
/*
*  
*  YAF FRAMEWORK version 2.2.7
* 
* --------------------------------------------------------------------
*  入口文件
* --------------------------------------------------------------------
*
*  @authors ekin.cen <yijian.cen@gmail.com>
*  
*  @copyright  Copyright (c)  2012 - ekin studio
*  
*/
define('APP_PATH',realpath(dirname(__FILE__).'/../'));
define('BASE_PATH',APP_PATH.'/application/');
define('CONF_PATH',APP_PATH.'/conf/');
define('PUBLIC_PATH', APP_PATH.'/public/');
$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
/* End of file */