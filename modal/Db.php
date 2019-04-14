<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/4
 * Time: 21:49
 */
namespace modal;
use PDO as PDO;
abstract class Db {
    protected $_db;

    public function __construct()
    {
        $this->_db = self::getDb();
    }

    private static $db;
    public static function getDb() {
        if(!self::$db instanceof PDO) {
            require_once '../setting/db.inc.php';
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            );
            $dsn = "{$setting['driver']}:host={$setting['host']};dbname={$setting['dbname']};port={$setting['port']};charset={$setting['charset']}";
            self::$db = new PDO($dsn, $setting['user'], $setting['pwd'], $options);
//            self::$db->query('set names utf8');
        }
        return self::$db;
    }
}