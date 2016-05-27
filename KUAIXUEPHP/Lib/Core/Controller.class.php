<?php
class Controller{
    /**
     * 成功提示方法
     */
    protected function success($message, $jumpUrl='', $waitSecond=3){
        $jumpUrl = $jumpUrl ? $jumpUrl : 'javascript:history.back(-1);';
        include APP_TPL_PATH . '/success.html';
    }

    protected function error($message, $jumpUrl='', $waitSecond=3){
        $jumpUrl = $jumpUrl ? $jumpUrl : 'javascript:history.back(-1);';
        include APP_TPL_PATH . '/error.html';
    }
}