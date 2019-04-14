<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/4
 * Time: 22:04
 */
namespace modal\admin;

use modal\Db;

class User extends \modal\Db {

    const USER_ROLE_NORMAL = 1; //普通用户
    const USER_ROLE_ADMIN = 2; //后台管理员
    const USER_ROLE_SUPER_ADMIN = 3; //超级管理员

    static function user_roles($k = false) {
        $a = array(
            self::USER_ROLE_NORMAL => '普通用户',
            self::USER_ROLE_ADMIN  => '管理员',
            self::USER_ROLE_SUPER_ADMIN => '超级管理员'
        );
        if($k !== false) {
            return $a[$k];
        }else {
            return $a;
        }
    }

    public function getUserList($username, $mobile, $email) {

        $wherep = array();
        $where = "1=1";
        if($username) {
            $where .= ' AND cnickname like :username';
            $wherep[':username'] = "%{$username}%";
        }
        if($mobile) {
            $where .= ' AND cmobile like :mobile';
            $wherep[':mobile'] = "%{$mobile}%";
        }
        if($email) {
            $where .= ' AND cemail like :email';
            $wherep[':email'] = "%{$email}%";
        }
        $stmt = $this->_db->prepare('SELECT * FROM users WHERE ' . $where);
//        $stmt->bindParam('name', $name);
        $list = array();
        if($stmt->execute($wherep)) {
            while($row = $stmt->fetch()) {
                $list[] = $row;
            }
        }
        return $list;
    }

    public static function getUserByUid($uid) {
        $db = Db::getDb();
        $user = null;
        $stmt = $db->prepare('SELECT * FROM users WHERE uid = :uid');
        if($stmt->execute(array(':uid' => $uid))) {
            $user = $stmt->fetch();
        }
        return $user;
    }

    public static function getUserByNickName($cnickname) {
        $db = Db::getDb();
        $user = null;
        $stmt = $db->prepare('SELECT * FROM users WHERE cnickname = :name');
        if($stmt->execute(array(':name' => $cnickname))) {
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return $user;
    }

    public static function getUserByMobile($mobile) {
        $db = Db::getDb();
        $user = null;
        $stmt = $db->prepare('SELECT * FROM users WHERE cmobile = :mobile');
        if($stmt->execute(array(':mobile' => $mobile))) {
            $user = $stmt->fetch();
        }
        return $user;
    }

    public static function getUserByEmail($email) {
        $db = Db::getDb();
        $user = null;
        $stmt = $db->prepare('SELECT * FROM users WHERE cemail = :email');
        if($stmt->execute(array(':email' => $email))) {
            $user = $stmt->fetch();
        }
        return $user;
    }

    /**
     * 添加用户
     * @param $cnickname
     * @param $pwd
     * @param $mobile
     * @param $email
     * @param $role
     * @param $province
     * @param $city
     * @param $address
     */
    public static function add($cnickname, $pwd, $mobile, $email, $role, $province, $city, $address) {
        $db = Db::getDb();
        $uid = guid();
        if(!$cpasswod = password_hash($pwd, PASSWORD_DEFAULT, array('cost' => HASH_COST))) {
            return false;
        }
        $itime = time();

        $stmt = $db->prepare('INSERT INTO users(uid, cnickname, cpassword, cmobile, cemail, cprovince, ccity, irole, itime) VALUES(:uid, :nickname, :password, :mobile, :email, :province, :city, :role, :itime)');
        $stmt->bindParam(':uid', $uid);
        $stmt->bindParam(':nickname', $cnickname);
        $stmt->bindParam(':password', $cpasswod);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':itime', $itime);
        if(!$stmt->execute()) {
            return false;
        }
        return $uid;
    }

    public static function setIpAndTime($uid) {
        $user = static::getUserByUid($uid);
        if($user) {
            $db = static::getDb();
            $time = time();
            $req = request();
            $ip = $req->getClientIp();
            $stmt = $db->prepare('update users set ilast_login_time = :time, clast_login_ip = :ip where uid = :uid');
            $stmt->execute(array(':time' => $time, ':ip' => $ip, ':uid' => $uid));
        }
    }

}