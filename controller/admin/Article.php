<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/9
 * Time: 22:29
 */
namespace controller\admin;
use modal\admin\Article as SArticle;
class Article extends AdminAuth {

    public function index() {
        $ichannel = _PI('ichannel', SArticle::INFO_CHANNEL_PROGRAM);
        $itype = _PI('itype', '');
        $kword = _P('kword', '');
        $page = _PI('page');
        $page <= 0 && $page = 1;

        $list_info = SArticle::getList($kword, $ichannel, $itype, $page);
        _S('title', '文章列表');
        _S('list', $list_info['list']);
        _S('ichannel', $ichannel);
        _S('itype', $itype);
        $this->fetch('admin/article/index');
    }

    function add() {
        $this->fetch('/admin/article/add');
    }
}