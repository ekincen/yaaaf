<?php
/*
 *
 *  YAF FRAMEWORK version 2.2.7
 *
 * --------------------------------------------------------------------
 *  Layout Class. two step view. 布局模版类
 * --------------------------------------------------------------------
 *
 *  @author ekin.cen <yijian.cen@gmail.com>
 *
 *  @copyright  Copyright (c)  2012 - ekin studio
 *
*/

class System_Layout {
    protected $_view;
    protected $_disable_layout = false;
    protected $_layout;
    const LAYOUT_PATH = 'layout';
    const TEMPLATE_PATH = 'template';
    /*
     * @desc 设置引用的视图类
    */
    public function setView($view) {
        $this->_view = $view;
        
        return $this;
    }
    /*
     * @desc 设置布局路径前缀
    */
    public function setLayoutPath() {
    }
    /*
     * @desc 设置布局模版
    */
    public function setLayout($layout) {
        $this->_layout = $layout . '.phtml';
        
        return $this;
    }
    /*
     * @desc 禁用模版输出
    */
    public function disableLayout($bool = true) {
        $this->_disable_layout = (boolean)$bool;
        
        return $this;
    }
    /*
     * @desc assign视图参数
    */
    public function assign($key, $value) {
        $this->_view->assign($key, $value);
        
        return $this;
    }
    /*
     * @desc 显示模版内容
    */
    public function display($template) {
        $template_content = $this->_view->render(self::TEMPLATE_PATH . '/' . $template . '.phtml');
        if (!$this->_disable_layout) {
            //filter headscript in content
            if(preg_match('/<head>(.*)<\/head>/si', $template_content,$head_script)){
                $template_content=str_replace(array('<head>'.$head_script[1].'</head>','<body>','</body>'), '', $template_content);
                $head_script=$head_script[1];
            }else{
                $head_script=null;
            }
            //set layout view
            $this->_view->assign(array(
                'HEAD_SCRIPT'=>$head_script,
                'CONTENT'=>$template_content
                ));
            $this->_view->display(self::LAYOUT_PATH . '/' . $this->_layout);
        } else {
            //output template
            echo $template_content;
        }
    }
    public function __set($property, $value) {
        $this->_view->$property = $value;
    }
    public function __get($property) {

        return $this->_view->$property;
    }
}
/* End of file */
