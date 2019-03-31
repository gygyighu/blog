<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/2/26
 * Time: 20:31
 */
namespace controller\admin;

use controller\Controller;
use modal\Db;
use PDO as PDO;
class User extends Controller {

    function index() {
        $request = request();
        $user = new \modal\admin\User();
        $list = $user->getUserList();
        $this->setTempVal('list', $list);
        $this->fetch('admin/user/index');
    }

}