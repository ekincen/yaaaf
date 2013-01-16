<?php
/*
 *
 *  YAF FRAMEWORK version 2.2.7
 *
 * --------------------------------------------------------------------
 *  Description Action抽象类
 * --------------------------------------------------------------------
 *
 *  @author ekin.cen <yijian.cen@gmail.com>
 *
 *  @copyright  Copyright (c)  2012 - ekin studio
 *
*/

class System_Action_Abstract extends Yaf_Action_Abstract {
    public function execute() {
    }
    public function __call($method, $arguments) {
        $controller = $this->getController();
        if (method_exists($controller, $method)) {
            
            return call_user_func(array(
                $controller,
                $method
            ) , $arguments);
        }
        exit("Undefined method '{$method}' in action controller " . $controller->getControllerName());
    }
}
/* End of file */
