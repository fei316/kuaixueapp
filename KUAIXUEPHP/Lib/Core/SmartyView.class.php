<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-06-26
 * Time: 15:46
 */
class SmartyView
{
    private static $smarty = null;

    public function __construct(){
        if (!is_null(self::$smarty)) return;
        $smarty = new Smarty();
        //模板目录
        $smarty->template_dir = APP_TPL_PATH . '/' . CONTROLLER . '/';
        //编译
        $smarty->compile_dir = APP_COMPILE_PATH;
        //缓存
        $smarty->cache_dir = APP_CACHE_PATH;
        $smarty->left_delimiter = C('LEFT_DELIMITER');
        $smarty->right_delimiter = C('RIGHT_DELIMITER');
        $smarty->caching = C('CACHE_ON');
        $smarty->cache_lifetime = C('CACHE_TIME');
        self::$smarty = $smarty;
    }

    protected function display($tpl){
        self::$smarty->display($tpl, $_SERVER['REQUEST_URI']);
    }

    protected function assign($var, $value){
        self::$smarty->assign($var, $value);
    }

    protected function is_cached($tpl=null){
        if (C('SMARTY_ON')) halt('请先开启Smarty');
        $tpl = $this->get_tpl($tpl);
        return self::$smarty->is_cached($tpl, $_SERVER['REQUEST_URI']);
    }
















}