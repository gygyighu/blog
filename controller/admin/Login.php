<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/11
 * Time: 21:55
 */
namespace controller\admin;
use common\Util;
use modal\Db;

class Login extends AdminController
{

    public function index()
    {
        if ($this->admin) {
            return redirect('/index.php/admin/user/index');
        }
        $this->fetch('admin/login/index');
    }

    function cklogin()
    {

        try {
            $cnickname = _P('cnickname');
            $pwd = _P('pwd');

            if (empty($cnickname) || empty($pwd)) {
                throw new \Exception('请输入用户名或密码');
            }
            if (is_mobile($cnickname)) {
                $user = \modal\admin\User::getUserByMobile($cnickname);
            } else {
                $user = \modal\admin\User::getUserByNickName($cnickname);
            }
            if (empty($user)) {
                throw new \Exception('用户不存在，请重新输入');
            }
            if (!password_verify($pwd, $user['cpassword'])) {
                throw new \Exception('密码不正确，请重新输入');
            }
            \modal\admin\User::setIpAndTime($user['uid']);
            $_SESSION['admin_uid'] = $user['uid'];
            $_SESSION['admin_login'] = true;
            if (password_needs_rehash($user['cpassword'], PASSWORD_DEFAULT, array('cost' => HASH_COST))) {
                $pwd = password_hash($pwd, PASSWORD_DEFAULT, array('cost' => HASH_COST));
                $db = Db::getDb();
                $stmt = $db->prepare('update users set cpassword = :pwd where uid = :uid');
                $stmt->execute(array(':pwd' => $pwd, ':uid' => $user['uid']));
            }

            Util::return_json(AJAX_SUCCESS, 'success');
        } catch (\Exception $e) {
            Util::return_json(AJAX_FAIL, $e->getMessage());
        }
    }

    /*
     * 退出登录
     */
    function logout()
    {
        unset($_SESSION['admin_uid']);
        $_SESSION['admin_login'] = false;
        $req = request();
        $back_url = $req->server->get('HTTP_REFERER');
//        var_dump($back_url);die;
        return redirect('/index.php/admin/login/index?back_url=' . $back_url);
    }
}