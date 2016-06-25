<?php
class Controller{
    private $var = array();

    public function __construct(){
        if (method_exists($this, '__init')) {
            $this->__init();
        }

        if (method_exists($this, '__auto')) {
            $this->__auto();
        }
    }

    /**
     * @param null $tpl
     */
    protected function display($tpl=null){
        if (is_null($tpl)) {
            $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . ACTION . '.html';
        } else {
            $suffix = strrchr($tpl, '.');
            $tpl = empty($suffix) ? $tpl . '.html' : $tpl;
            $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . $tpl;
        }

        if (!is_file($path)) halt($path . '模板文件不存在');
        extract($this->var);
        include $path;
    }

    protected function assign($var, $value){
        $this->var[$var] = $value;
    }

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
?>