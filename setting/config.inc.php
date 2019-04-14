<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/3/31
 * Time: 11:19
 */

define('APP_ROOT', 'D:/www/new_blog');
define('SITE_NAME', '测试博客');
define('FS_DEBUG', true);
define('SITE_URL', 'www.note.com');

define('AJAX_SUCCESS', 0);
define('AJAX_FAIL', 999);

//hash复杂度
define('HASH_COST', 12);

define('ADMIN_PAGE_SIZE', 20);
define('WEB_PAGE_SIZE', 10);

function MENU($k = false) {
    $menu = array(
      'User' => array(
          'title' => '用户管理',
          'icon' => 'fa-users',
          'methods' => array(
              'index' => array(
                  'title' => '用户列表',
                  'url'   => '/index.php/admin/user/index'
              ),
              'groups' => array(
                  'title' => '组别列表',
                  'url'   => '/index.php/admin/user/groups'
              )
          )
      ),
        'Article' => array(
            'title' => '文章管理',
            'icon'  => 'fa-file',
            'methods' => array(
                'index' => array(
                    'title' => '文章列表',
                    'url'   => '/index.php/admin/article/index'
                )
            )
        )
    );
    if($k !== false) {
        return $menu[$k];
    }else {
        return $menu;
    }
}