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
class AutocompleteController extends System_Controller_Ajax{


	public function getmodelAction(){
		echo json_encode(array(array('id'=>'23','name'=>'test')));
	}
}
/* End of file */