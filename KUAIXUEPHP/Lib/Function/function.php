<?php
function halt($error, $level='ERROR', $type=3, $dest=null){
    if (is_array($error)) {
        Log::write($error['message'], $level, $type, $dest);
    } else {
        Log::write($error, $level, $type, $dest);
    }

    $e = array();
    if (DEBUG) {
        if (!is_array($error)) {
            $trace = debug_backtrace();
            $e['message'] = $error;
            $e['file'] = $trace[0]['file'];
            $e['line'] = $trace[0]['line'];
            $e['class'] = isset($trace[0]['class']) ? $trace[0]['class'] : '';
            $e['function'] = isset($trace[0]['function']) ? $trace[0]['function'] : '';

            ob_start();
            debug_print_backtrace();
            $e['trace'] = htmlspecialchars(ob_get_clean());
        } else {
            $e = $error;
        }
    } else {
        if ($url = C('ERROR_URL')) {
            go($url);
        } else {
            $e['message'] = C('ERROR_MSG');
        }
    }

    include DATA_PATH . '/Tpl/halt.html';
    die;
}

/**
 * 打印函数
 * @param $arr
 */
function p($arr){
    if (is_bool($arr)) {
        var_dump($arr);
    } else if (is_null($arr)) {
        var_dump(null);
    } else {
        echo '<pre style="padding:10px;border-radius:5px;background:#f5f5f5;border:1px solid #ccc;font-size:14px;">' . print_r($arr, true) . '</pre>';
    }
}

/**
 * @param $url
 * @param int $time
 * @param string $msg
 */
function go($url, $time=0, $msg=''){
    if (!headers_sent()) {
        $time == 0 ? header('Location:' . $url) : header("refresh:{$time};url={$url}");
        die($msg);
    } else {
        echo "<meta http-equiv='Refresh' content='{$time};URL={$url}'></meta>";
        if ($time) die($msg);
    }
}

/**
 * 1.加载配置项
 * C($sysConfig) C($userConfig)
 *
 * 2.读取配置项
 * C('CODE_LEN')
 *
 * 3.临时动态改变配置项
 * C('CODE_LEN',20)
 *
 * 4.读取所有配置项
 * C()
 */
function C($var = null, $value = null) {
    static $config = array();
    //加载配置项
    if (is_array($var)) {
        $config = array_merge($config, array_change_key_case($var, CASE_UPPER));
        return;
    }
    //读取或者动态改变配置项
    if (is_string($var)) {
        $var = strtoupper($var);
        //传递两个参数
        if (!is_null($value)) {
            $config[$var] = $value;
            return;
        }

        return isset($config[$var]) ? $config[$var] : null;
    }

    //返回所有的配置项
    if (is_null($var) && is_null($value)) {
        return $config;
    }
}

function print_const(){
    $const = get_defined_constants(true);
    p($const['user']);
}

function M($table){
    $obj = new Model($table);
    return $obj;
}

function K($model){
    $model .= "Model";
    return new $model;
}




?>