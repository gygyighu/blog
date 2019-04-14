<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/9
 * Time: 22:00
 */
namespace modal\admin;
use modal\admin\User;

class Article extends \modal\Db
{
    const INFO_CHANNEL_PROGRAM = 1;
    const INFO_CHANNEL_HOT = 2;
    const INFO_CHANNEL_ESSAY = 3;
    const INFO_CHANNEL_OTHER = 4;
    //频道
    public static function channels($k = false) {
        $a = array(
            self::INFO_CHANNEL_PROGRAM => '编程',
            self::INFO_CHANNEL_OTHER   => '其他',
        );
        if($k !== false) {
            return $a[$k];
        }else {
            return $a;
        }
    }

    //类型
    public static function types($k = false, $v = false) {
        $a = array(
            self::INFO_CHANNEL_PROGRAM => array(
                1  => 'c/c++',
                2  => 'PHP',
                3  => 'java',
                4  => 'js',
                5  => 'Python',
                6  => 'html',
                7  => 'css'
            ),
            self::INFO_CHANNEL_OTHER => array(
                1 => '全部',
            )
        );
        if($k !== false) {
            if($v !== false) {
                if(empty($a[$k])) {
                    return null;
                }
                return $a[$k][$v];
            }else {
                return $a[$k];
            }
        }else {
            return $a;
        }
    }

    /**
     * 获取列表
     * @return array
     */
    public static function getList($kword, $ichannel, $itype, $page = 1) {
        $db = static::getDb();
        $list = array();
        $where = '1=1';
        $wherep = array();

        if($kword) {
            $where .= ' AND ctitle like :title';
            $wherep[':title'] = "%{$kword}%";
        }
        if($ichannel) {
            $where .= ' AND ichannel = :channel';
            $wherep[':channel'] = $ichannel;
        }
        if($itype) {
            $where .= ' AND itype = :type';
            $wherep[':type'] = $itype;
        }
        $count = 0;
        $stmt_count = $db->prepare('select count(*) as num from articles where '. $where);
        if($stmt_count->execute($wherep)) {
            $row = $stmt_count->fetch();
            $count = $row['num'];
        }
        $where .= ' ORDER By itime DESC LIMIT :page, :page_size';
        $wherep[":page"] = ($page - 1) * ADMIN_PAGE_SIZE;
        $wherep[":page_size"] = ADMIN_PAGE_SIZE;

        $stmt = $db->prepare('SELECT * FROM articles WHERE ' . $where);
        if($stmt->execute($wherep)) {
            while($row = $stmt->fetch()) {
                $user = User::getUserByUid($row['uid']);
                $row['user'] = $user;
                $list[] = $row;
            }
        }
        return array('list' => $list, 'total' => $count);
    }
}