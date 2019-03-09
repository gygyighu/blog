<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/4
 * Time: 22:04
 */
namespace modal\admin;

class User extends \modal\Db {


    public function getUserList() {

        $stmt = $this->_db->prepare('SELECT * FROM users WHERE 1');
//        $stmt->bindParam('name', $name);
        $list = array();
        if($stmt->execute()) {
            while($row = $stmt->fetch()) {
                $list[] = $row;
            }
        }
        var_dump($list);
    }
}