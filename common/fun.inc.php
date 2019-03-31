<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/10
 * Time: 16:07
 */
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

function getApp() {
    if(isset($GLOBALS['app'])) {
        return $GLOBALS['app'];
    }else {
        return null;
    }
}
/**
 * 返回当前控制器
 */
function getClass() {
    $class = '';
    if($app = getApp()) {
        $class =  $app->getClass();
    }
    return $class;
}

/**
 * 返回当前方法
 */
function getAction() {
    $action = '';
    if($app = getApp()) {
        $action = $app->getAction();
    }
    return $action;
}

function guid() {
    $uuidFactory = new \Ramsey\Uuid\UuidFactory();
    $uuidFactory->setRandomGenerator(new \Ramsey\Uuid\Generator\RandomLibAdapter());
    Uuid::setFactory($uuidFactory);

    return Uuid::uuid4()->toString();
}

function request() {
    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
    return $request;
}

function _I($path) {
    include APP_ROOT . $path;
}