<?php
class Controller extends SmartyView{
    private $var = array();

    public function __construct(){
        if (C('SMARTY_ON')) parent::__construct();
        if (method_exists($this, '__init')) {
            $this->__init();
        }

        if (method_exists($this, '__auto')) {
            $this->__auto();
        }
    }

    protected function get_tpl($tpl){
        if (is_null($tpl)) {
            $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . ACTION . '.html';
        } else {
            $suffix = strrchr($tpl, '.');
            $tpl = empty($suffix) ? $tpl . '.html' : $tpl;
            $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . $tpl;
        }
        return $path;
    }

    /**
     * @param null $tpl
     */
    protected function display($tpl=null){
        $path = $this->get_tpl($tpl);
        if (!is_file($path)) halt($path . '模板文件不存在');
        if (C('SMARTY_ON')) {
            parent::display($path);
        } else {
            extract($this->var);
            include $path;
        }
    }

    protected function assign($var, $value){
        if (C('SMARTY_ON')) {
            parent::assign($var, $value);
        } else {
            $this->var[$var] = $value;
        }

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