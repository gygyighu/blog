<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/5
 * Time: 2:02
 */
use Symfony\Component\HttpFoundation\Request;
class CRequest {
    protected $request;
    private static $instance;
    public static function getInstance() {
        if(!static::$instance instanceof CRequest) {
            static::$instance = new CRequest();
        }
        return static::$instance;
    }

    private function __construct()
    {
        $this->request = Request::createFromGlobals();
    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}