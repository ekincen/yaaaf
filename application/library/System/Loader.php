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
class System_Loader{

	protected static $_instance;

	protected static $_models=array();

	private function __construct(){
	}

	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance=new self();
		}
		return self::$_instance;
	}

	public function getModel($model_name,$path=null){
		if(!isset(self::$_models[$model_name])){
			$model_name.='Model';
			self::$_models[$model_name]=new $model_name();
		}
		return self::$_models[$model_name];
	}
}
/* End of file */