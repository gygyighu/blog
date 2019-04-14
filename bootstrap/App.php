<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/7
 * Time: 23:14
 */
namespace bootstrap;
class App {

    private $controller;
    private $module;
    private $class;
    private $action;

    function __construct()
    {
        $this->setModule('');
        $this->setClass('');
        $this->setAction('');
        $GLOBALS['app'] = $this;
    }

    function ready() {
        return $this->controller->__init();
    }

    /**
     * 初始化
     */
    public function init() {
        $path_info = $_SERVER['PATH_INFO'];
        $path_params = $path_info ? explode('/', substr($path_info, 1)) : array();

        $module = empty($path_params[0]) ? 'admin' : strtolower($path_params[0]);
        $controller = empty($path_params[1]) ? 'user' : strtolower($path_params[1]);
        $action = empty($path_params[2]) ? 'index' : strtolower($path_params[2]);
        $action_vals = explode('_', $action);
        $_action = '';
        foreach($action_vals as $k => $v) {
            if($k == 0) {
                $_action .= $v;
            }else {
                $_action .= ucfirst($v);
            }
        }
        $_controller = ucfirst($controller);
        $class = 'controller\\' . $module . '\\' . $_controller;
        if(!class_exists($class)) {
            $this->pageNotFound();
        }else {
            $controller_instancec = new $class();
            $this->controller = $controller_instancec;
            $this->setModule($module);
            $this->setClass($_controller);
            $this->setAction($_action);
        }
    }

    function run() {
        if(method_exists($this->controller, $this->getAction())) {
            $action = $this->getAction();
            $this->controller->$action();
        } else {

        }
    }

//-------setter-------
    function setModule($module = '') {
        $this->module = $module;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function setAction($action) {
        $this->action = $action;
    }

    //------getter-------
    function getModule() {
        return $this->module;
    }

    function getClass() {
        return $this->class;
    }

    function getAction() {
        return $this->action;
    }


    function pageNotFound() {
        Header("HTTP/1.1 404 Not Found");
        echo 'page not found';
        exit;
    }
}