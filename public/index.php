<?php
    error_reporting(E_ALL & ~E_NOTICE);
    date_default_timezone_set('Asia/Shanghai');

    define('APP_ROOT', 'D:/www/new_blog');

    require_once '../setting/setting.inc.php';
    require_once '../bootstrap/autoload.php';


    $app = new \bootstrap\App();
    $app->init();
    $app->run();

