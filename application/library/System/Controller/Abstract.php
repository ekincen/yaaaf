<?php
/*
 *
 *  YAF FRAMEWORK version 2.2.7
 *
 * --------------------------------------------------------------------
 *  Description 网站页面的控制器，默认需要会员登入
 * --------------------------------------------------------------------
 *
 *  @author ekin.cen <yijian.cen@gmail.com>
 *
 *  @copyright  Copyright (c)  2012 - ekin studio
 *
*/

class System_Controller_Abstract extends Yaf_Controller_Abstract {
    protected $_loader;
    protected $_identity;
    protected $_layout;
    protected $_layout_template='layout_home';
    protected $_model_arr=array();

    public function init() {
        $this->_setIdentity();
        $this->_checkAuth();
        $this->_initialize();
    }
    //控制器初始化
    protected function _initialize() {
    }
    //输出模版布局
    public function getLayout() {
        if (!$this->_layout) {
            $this->_layout = new System_Layout();
            $this->_layout->setView($this->getView())->setLayout($this->_layout_template);
        }
        //检查是否来自pjax的请求
        if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
            $this->_layout->disableLayout();
        }
        return $this->_layout;
    }
    //获取Model方法
    public function getModel($model_name,$path=null){
        if(!$this->_loader){
            $this->_loader=System_Loader::getInstance();
        }
        return $this->_loader->getModel($model_name,$path);
    }
    //获取控制器名
    public function getControllerName() {
        return $this->_name;
    }

    //设置身份
    protected function _setIdentity() {
        $this->_identity = YAF_Session::getInstance()->get('identity');
        $this->getView()->_identity=$this->_identity;
    }
    //检查身份，适用于controller中
    protected function _checkAuth() {
        $this->_require_login();
    }

    //请求登陆的方法，适用于单独action中
    protected function _require_login(){
        // if (!$this->_identity) {
        //     $this->redirect('/portal/login');
        // }
    }
}
/* End of file */
