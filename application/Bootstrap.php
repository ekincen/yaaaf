<?php
/*
 *
 *  YAF FRAMEWORK version 2.2.7
 *
 * --------------------------------------------------------------------
 *  Bootstrap file
 * --------------------------------------------------------------------
 *
 *  @author ekin.cen <yijian.cen@gmail.com>
 *
 *  @copyright  Copyright (c)  2012 - ekin studio
 *
*/

class Bootstrap extends Yaf_Bootstrap_Abstract {
	public function _initDispatcher() {
		//存入配置
		$config=Yaf_Application::app()->getConfig();
		Yaf_Registry::set('config', $config);
		//关闭视图输出
		$dispatcher=Yaf_Dispatcher::getInstance();
		$dispatcher->disableView();
		//添加配置中的路由
		$dispatcher->getRouter()->addConfig($config->routes);
	}
}
/* End of file */