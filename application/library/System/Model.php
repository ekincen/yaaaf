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
class System_model{

	protected $_loader;

	public function __construct(){

	}

	public function getModel($model_name,$path=null){
		if(!$this->_loader){
			$this->_loader=System_Loader::getInstance();
		}
		return $this->_loader->getModel($model_name,$path);
	}
}
/* End of file */