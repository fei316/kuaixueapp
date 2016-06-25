<?php
return array(
    //验证码位数
    'CODE_LEN'  => 4,

    //默认时区
    'DEFAULT_TIME_ZONE' => 'PRC',

    //session自动开启
    'SESSION_AUTO_START' => true,

    'VAR_CONTROLLER' => 'c',
    'VAR_ACTION' => 'a',
    //是否开始日志
    'SAVE_LOG'  => true,

    //错误跳转的地址
    'ERROR_URL' => '',
    //错误提示的信息
    'ERROR_MSG' => '网站出错了,请稍后再试',

    //自动加载Common/Lib目录下的文件
    'AUTO_LOAD_FILE'    => array('func.php'),
);