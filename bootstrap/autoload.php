<?php
/**自动加载
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/2/26
 * Time: 21:08
 */
require_once APP_ROOT .'/setting/setting.inc.php';
spl_autoload_register(function($classname) use ($root_namespace) {
    foreach($root_namespace as $k => $v) {
        $_k = $k . '\\';
        $len = strlen($_k);
        if(substr($classname, 0, $len) == $_k) {
            $relat_class = substr($classname, $len);
            $relat_class = str_replace('\\', '/', $relat_class);
            $file_path = $v . '/' . $relat_class . '.php';
            if(file_exists($file_path)) {
                require_once $file_path;
                return true;
            }
        }
    }

    return false;
});

set_exception_handler(function(Exception $e) {
    if(FS_DEBUG) {
        echo $e->getMessage();
    }
    error_log($e->getMessage() . "\t" . $e->getTraceAsString());
});