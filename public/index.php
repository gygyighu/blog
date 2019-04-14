<?php
/**
 *
 */
    error_reporting(E_ALL & ~E_NOTICE);
    date_default_timezone_set('Asia/Shanghai');
    session_start();

    require_once '../setting/config.inc.php';
    require_once '../setting/setting.inc.php';
    require_once '../bootstrap/autoload.php';
    require_once '../vendor/autoload.php';
    require_once '../common/fun.inc.php';


    $app = new \bootstrap\App();
    $app->init();
    if($app->ready()) {
        $app->run();
    }

