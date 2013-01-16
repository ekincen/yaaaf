<?php
/*
 *
 *  YAF FRAMEWORK version 2.2.7
 *
 * --------------------------------------------------------------------
 *  Description  Ajax控制器
 * --------------------------------------------------------------------
 *
 *  @author ekin.cen <yijian.cen@gmail.com>
 *
 *  @copyright  Copyright (c)  2012 - ekin studio
 *
*/

class System_Controller_Ajax extends System_Controller_Abstract {
    
    protected function iniController() {
        //check if is ajax request
        // if (!$this->input->is_ajax_request())
        //  show_404();

    }
    /**
     *
     *
     * @desc 操作错误跳转的快捷方法
     * @access protected
     * @param string  $message 错误信息
     * @return void
     */
    protected function error($message) {
        $this->ajaxReturn(null, $message, 0);
    }
    /**
     *
     *
     * @desc 操作成功跳转的快捷方法
     * @access protected
     * @param string  $message 提示信息
     * @return void
     */
    protected function success($message) {
        $this->ajaxReturn(null, $message, 1);
    }
    /**
     *
     *
     * @desc Ajax方式返回数据到客户端
     * @access protected
     * @param mixed   $data   要返回的数据
     * @param string  $info   提示信息
     * @param boolean $status 返回状态
     * @param string  $status ajax返回类型 JSON XML
     * @return void
     */
    protected function ajaxReturn($data, $info = '', $status = 1, $type = 'JSON') {
        $result = array();
        $result['status'] = $status;
        $result['info'] = $info;
        $result['data'] = $data;

        switch (strtoupper($type)) {
            case 'JSON':
            // 返回JSON数据格式到客户端 包含状态信息
            header('Content-Type:text/html; charset=utf-8');
            exit(json_encode($result));
            break;

            case 'XML':
            // 返回xml格式数据
            header('Content-Type:text/xml; charset=utf-8');
            exit(xml_encode($result));
            break;

            default:
            // 返回可执行的js脚本
            header('Content-Type:text/html; charset=utf-8');
            exit($data);
            break;
        }
    }
}
/* End of file */
