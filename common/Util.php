<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/6
 * Time: 10:37
 */
namespace common;
class Util {

    public static function return_json($errcode, $msg = '', $data = array()) {
        echo json_encode(array('errcode' => $errcode, 'msg' => $msg, 'data' => $data));
        return false;
    }
}