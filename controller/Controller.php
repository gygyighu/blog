<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/9
 * Time: 17:08
 */
namespace controller;

class Controller {

    protected $temp_val;

    public function __construct()
    {
        $this->temp_val = array();
    }

    protected function setTempVal($k, $v) {
        if(is_object($k) || $k === false || $k === '') {
            return;
        }
        $this->temp_val[$k] = $v;
    }

    protected function getTempVal($k = false) {
        if($k === false) {
            return $this->temp_val;
        }else {
            return $this->temp_val[$k];
        }
    }

    protected function fetch($temp) {
        $temp_file = APP_ROOT . '/view/' . $temp . '.inc.php';
//        var_dump($temp);
//        var_dump($temp_file);die;
        if(!file_exists($temp_file)) {
            die($temp_file . ' not exists!');
        }
        ob_start();
        include $temp_file;
        ob_end_flush();
    }
}