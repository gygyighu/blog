<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/2/26
 * Time: 20:31
 */
namespace controller\admin;

use common\UploadException;
use common\Util;
use controller\Controller;
use modal\Db;

class User extends AdminAuth {


    function index() {
        $request = request();
        $username = $request->query->get('username', '');
        $cemail = $request->query->get('cemail', '');
        $cmobile = $request->query->get('cmobile', '');

        $user = new \modal\admin\User();
        $list = $user->getUserList($username, $cmobile, $cemail);

//        $this->setTempVal('title', '用户列表');
//        $this->setTempVal('list', $list);
        _S('title', '用户列表');
        _S('list', $list);
        $this->fetch('admin/user/index');
    }

    function add() {
        $do = _P('do');
        if(empty($do)) {
            $this->fetch("admin/user/add");
            return true;
        }
        try{
            $cnickname = _P('cnickname');
            $pwd = _P('pwd');
            $cemail = _P('cemail');
            $cmobile = _P('cmobile');
            $irole = _PI('irole');
            $cprovince = _P('cprovince');
            $ccity = _P('ccity');
            $caddress = _P('caddress', '');

            if(empty($cnickname)) {
                throw new \Exception('请输入昵称');
            }
            if(empty($pwd) || strlen($pwd) < 6) {
                throw new \Exception('密码长度不能小于6位');
            }
            if($user = \modal\admin\User::getUserByNickName($cnickname)) {
                throw new \Exception('用户名已存在，请重新输入');
            }
            if(empty($cmobile) || !is_mobile($cmobile)) {
                throw new \Exception('请填写正确的手机号');
            }
            if(empty($cemail) || !is_email($cemail)) {
                throw new \Exception('请填写正确的邮箱地址');
            }
            if(empty(\modal\admin\User::user_roles($irole))) {
                throw new \Exception('请选择角色');
            }
            if(empty($cprovince) || empty($ccity)) {
                throw new \Exception('请选择省份和城市');
            }

            $uid = \modal\admin\User::add($cnickname, $pwd, $cmobile, $cemail, $irole, $cprovince, $ccity, $caddress);

            if(!$uid) {
                throw new \Exception('添加失败');
            }

            return Util::return_json(AJAX_SUCCESS, '添加成功');
        }catch (\Exception $e) {
            return Util::return_json(AJAX_FAIL, $e->getMessage());
        }
    }

    function mod() {
        $uid = _P('uid');
        $user = \modal\admin\User::getUserByUid($uid);
        if(empty($user)) {
            $this->error('系统错误，请稍后再试');
            return false;
        }
        _S('item', $user);
        $this->fetch("admin/user/mod");
        return true;
    }

    //用户资料编辑
    function pmod() {

        try {
            $uid = _P('uid');
            $cnickname = _P('cnickname');
            $gender = _PI('gender');
            $cmobile = _P('cmobile');
            $cemail = _P('cemail');
            $irole = _PI('irole');
            $cprovince = _P('cprovince');
            $ccity = _P('ccity');
            $caddress = _P('caddress');

            $user = \modal\admin\User::getUserByUid($uid);
            if(empty($user)) {
                throw new \Exception('系统错误，请稍后再试');
            }
            $data = array();
            if($user['cnickname'] != $cnickname) {
                if(empty($cnickname)) {
                    throw new \Exception('请输入用户名');
                }
                if($_user = \modal\admin\User::getUserByNickName($cnickname)) {
                    throw new \Exception('该用户名已存在，请重新输入');
                }
                $data['cnickname'] = $cnickname;
            }
            if($user['cmobile'] != $cmobile) {
                if(!is_mobile($cmobile)) {
                    throw new \Exception('请输入正确手机号');
                }
                if($_user = \modal\admin\User::getUserByMobile($cmobile)) {
                    throw new \Exception('改手机号已被使用，请重新输入');
                }
                $data['cmobile'] = $cmobile;
            }
            if($user['cemail'] != $cemail) {
                if(!is_email($cemail)) {
                    throw new \Exception('请输入正确的邮箱');
                }
                if($_user = \modal\admin\User::getUserByEmail($cemail)) {
                    throw new \Exception('该邮箱已被使用，请重新输入');
                }
                $data['cemail'] = $cemail;
            }
            if($user['gender'] != $gender) {
                $data['gender'] = $gender;
            }
            if($user['irole'] != $irole) {
                $data['irole']  = $irole;
            }
            if($user['cprovince'] != $cprovince) {
                $data['cprovince'] = $cprovince;
            }
            if($user['ccity'] != $ccity) {
                $data['ccity'] = $ccity;
            }
            if($user['caddress'] != $caddress) {
                $data['caddress'] = $caddress;
            }
            if($data) {
                $db = Db::getDb();
                $sql = 'UPDATE users SET';
                foreach($data as $k => $v) {
                    switch ($k) {
                        case 'cnickname':
                            $sql .= ' cnickname = :cnickname, ';
                            break;
                        case 'cmobile':
                            $sql .= ' cmobile = :cmobile, ';
                            break;
                        case 'cemail':
                            $sql .= ' cemail = :cemail, ';
                            break;
                        case 'gender':
                            $sql .= ' gender = :gender, ';
                            break;
                        case 'irole':
                            $sql .= ' irole = :irole, ';
                            break;
                        case 'cprovince':
                            $sql .= ' cprovince = :cprovince, ';
                            break;
                        case 'ccity':
                            $sql .= ' ccity = :ccity, ';
                            break;
                        case 'caddress':
                            $sql .= ' caddress = :caddress, ';
                            break;
                        default:
                    }
                }
                $sql = rtrim($sql, ', ');

                $sql .= ' WHERE uid = :uid';
                $data['uid'] = $uid;
//                var_dump($sql);die;
                $stmt = $db->prepare($sql);
                if(!$stmt->execute($data)) {
                    throw new \Exception('保存失败');
                }
            }

            return Util::return_json(AJAX_SUCCESS, '保存成功');
        }catch (\Exception $e) {
            return Util::return_json(AJAX_FAIL, $e->getMessage());
        }
    }

    function groups() {
        $db = Db::getDb();
        $stmt = $db->prepare('select * from ugroups');
        $list = array();
        if($stmt->nextRowset()) {
            while($row = $stmt->fetch()) {
                $list[] = $row;
            }
        }
        _S('title', '组别');
        _S('list', $list);
    }

    function modAvatar() {
        $req = request();
        $uid = _P('uid');
        $old_avatar = _P('old_avatar');
//        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile($_FILES['tmp_name'], $_FILES['min']);
        $file = $_FILES['avatar'];
        try{
            if(empty($old_avatar)) {
                if($file['error'] != UPLOAD_ERR_OK) {
                    throw new UploadException($file['error']);
                }
            }
            if($old_avatar && ($file['error'] != UPLOAD_ERR_OK) && $file['error'] != UPLOAD_ERR_NO_FILE) {
                throw new UploadException($file['error']);
            }

//            var_dump($file);die;
            $user = \modal\admin\User::getUserByUid($uid);
            if(empty($user)) {
                throw new \Exception('用户不存在');
            }
            if($old_avatar && $file['error'] == UPLOAD_ERR_NO_FILE) {
                $avatar = $old_avatar;
            }else {
                if(is_uploaded_file($file['tmp_name'])) {
                    $mime_types = array(
                        'bmp' => 'image/bmp',
                        'gif' => 'image/gif',
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'jpe' => 'image/jpeg',
                        'png'  => 'image/png',
                    );
                    if(!in_array($file['type'], $mime_types)) {
                        throw new \Exception('请上传图片');
                    }
                    $ext = strrchr($file['name'], '.');
                    $name = $uid . $ext;
                    $avatar = '/uploads/avatars/'.$name;
//                var_dump($name);die;
                    if(!move_uploaded_file($file['tmp_name'], APP_ROOT . '/public/uploads/avatars/'.$name)) {
                        throw new \Exception('上传失败');
                    }
                }else {
                    throw new \Exception('上传失败');
                }
            }
            $db = Db::getDb();
            $stmt = $db->prepare('UPDATE users set avatar = :avatar WHERE uid = :uid');
            $stmt->execute(array(':avatar' => $avatar, ':uid' => $uid));

            return Util::return_json(AJAX_SUCCESS, '保存成功');
        }catch (\Exception $e) {
            Util::return_json(AJAX_FAIL, $e->getMessage());
        }
    }
}