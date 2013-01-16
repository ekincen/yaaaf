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

class IndexController extends System_Controller_Public {

	public function indexAction() {
		$this->getLayout()->display("index/index");
	}
}
/* End of file */