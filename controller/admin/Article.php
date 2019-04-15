<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/9
 * Time: 22:29
 */
namespace controller\admin;
use common\Util;
use modal\admin\Article as SArticle;
use modal\Db;

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
        _S('title', '添加文章');
        $this->fetch('admin/article/add');
    }

    function gettypes() {
        $ichannel = _P('ichannel');
        $types = array();
        if(SArticle::channels($ichannel)) {
            $types = SArticle::types($ichannel);
        }
        return Util::return_json(AJAX_SUCCESS, 'success', array('types' => $types));
    }

    function padd() {
        try{
            $op = _P('operation', 1);
            $ichannel = _PI('ichannel', 0);
            $itype = _PI('itype', 0);
            $ctitle = _P('ctitle', '');
            $csubtitle = _P('csubtitle', '');
            $cauthor = _P('cauthor', '');
            $cabstract = _P('cabstract', '');
            $ccontent = _P('ccontent');
            $ishow = _PI('ishow', 0);

            $clogo = $_FILES['clogo'];

            if(empty(SArticle::channels($ichannel))) {
                throw new \Exception('请选择频道');
            }
            if(empty(SArticle::types($ichannel, $itype))) {
                throw new \Exception('请选择类型');
            }
            if($op == 2) {
                if(empty($ctitle)) {
                    throw new \Exception('请输入标题');
                }
                if(empty($ccontent)) {
                    throw new \Exception('请输入内容');
                }
                $status = 2;
            }else {
                $status = 0;
            }

            $url = '';
            if($clogo['error'] != UPLOAD_ERR_OK && $clogo['error'] != UPLOAD_ERR_NO_FILE) {
                throw new \Exception($clogo['error']);
            }
            if(!is_uploaded_file($clogo['tmp_name']) && $clogo['error'] != UPLOAD_ERR_NO_FILE) {
                throw new \Exception('上传失败');
            }
            if($clogo['error'] == UPLOAD_ERR_OK) {
                $ext = strrchr($clogo['name'], '.');
                $mimes = array(
                    'bmp' => 'image/bmp',
                    'gif' => 'image/gif',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpe' => 'image/jpeg',
                    'png'  => 'image/png',
                );
                if(!in_array($clogo['type'], $mimes)) {
                    throw new \Exception('请上传图片');
                }
                $_name = substr(0, strrpos('.', $clogo['name']), $clogo['name']);
                $name = md5($_name) . time() . rand(10000, 99999);
                $_dir = APP_ROOT . '/public/uploads/articles/' . date('y').'/'.date('m');
                if(!is_dir($_dir)) {
                    mkdir($_dir, 0777);
                }
                $url = '/uploads/articles/' . date('y').'/'.date('m') .'/'.$name . $ext;
                if(!move_uploaded_file($clogo['tmp_name'], $_dir . '/' . $name)) {
                    throw new \Exception('上传失败');
                }
            }

            $db = Db::getDb();
            $stmt = $db->prepare('insert into articles (aid, uid, ichannel, itype, ctitle, csubtitle, cauthor, cabstract, clogo, ccontent, ishow, istatus, itime)
                                values(:aid, :uid, :ichannel, :itype, :ctitle, :csubtitle, :cauthor, :cabstract, :clogo, :ccontent, :ishow, :istatus, :itime)');
            $data = array(
                ':aid'  => guid(),
                ':uid'   => $this->admin['uid'],
                ':ichannel' => $ichannel,
                ':itype'    => $itype,
                ':ctitle'   => $ctitle,
                ':csubtitle' => $csubtitle,
                ':cauthor'   => $cauthor,
                ':cabstract' => $cabstract,
                ':clogo'     => $clogo,
                ':ccontent'  => $ccontent,
                ':ishow'     => $ishow,
                ':istatus'   => $status,
                'itime'      => time()
            );
            if(!$stmt->execute($data)) {
                throw new \Exception('添加失败');
            }

            return Util::return_json(AJAX_SUCCESS, '添加成功');
        }catch (\Exception $e) {
            return Util::return_json(AJAX_FAIL, $e->getMessage());
        }
    }

}