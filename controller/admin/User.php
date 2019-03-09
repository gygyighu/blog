<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/2/26
 * Time: 20:31
 */
namespace controller\admin;

use modal\Db;
use PDO as PDO;
class User {

    function index() {

        var_dump(get_class($this));
    }
    function fetch($temp) {
        $temp_path = APP_ROOT . '/view/admin/' . $temp . '.inc.php';
        if(!file_exists($temp_path)) {
            exit($temp_path . ' does not exists!');
        }
        ob_start();
        include $temp_path;
        ob_end_flush();
    }

    function a() {
        var_dump(__METHOD__);
    }
    function userInfo() {
        $dsn = 'mysql:host=127.0.0.1;dbname=test;port=3306;charset=utf8';
        $user_name = 'root';
        $password = '577494';
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );
        try {
            $pdo = new PDO($dsn, $user_name, $password, $options);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit();
        }
        $name = '%camicaal%';
        $stmt = $pdo->prepare('SELECT * FROM users WHERE cnickname like :name');
//        $stmt->bindParam('name', $name);
        $list = array();
        if($stmt->execute(array(':name' => $name))) {
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }
        }
        var_dump($list);
    }
}