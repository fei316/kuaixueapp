<?php
final class Application
{
    public static function run() {
        self::_init();
    }

    /**
     * 初始化框架
     */
    private static function _init() {
        //加载配置项
        C(include CONFIG_PATH . '/config.php');

        $userPath = APP_CONFIG_PATH . '/config.php';

        $userConfig = <<<str
<?php
return array(
    //配置项 => 配置值
);
str;
        is_file($userPath) || file_put_contents($userPath, $userConfig);

        C(include $userPath);

        //设置默认时区
        date_default_timezone_set(C('DEFAULT_TIME_ZONE'));

        //是否开启session
        C('SESSION_AUTO_START') && session_start();
        echo C('CODE_LEN');
    }
}