<?php _I('/view/admin/header.inc.php');?>
<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <!-- #section:basics/sidebar -->
    <?php _I('/view/admin/leftside.inc.php');?>

    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <h1>
                    <?=_G('title')?>
                </h1>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-box transparent" style="background-color:#eff0f4;">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <form class="form-inline" action="">
                                            <div class="form-group">
                                                <label class="sr-only" for="username">用户名</label>
                                                <input type="text" name="username" value="<?=_P('username')?>" class="form-control" id="username" placeholder="请输入用户名">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="">手机号</label>
                                                <input type="text" name="cmobile" value="<?=_P('cmobile')?>" class="form-control" id="cmoble" placeholder="请输入手机号">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="">邮箱</label>
                                                <input type="text" name="cemail" value="<?=_P('cemail')?>" class="form-control" id="cemail" placeholder="请输入邮箱">
                                            </div>
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="ace-icon fa fa-key bigger-110"></i>搜索
                                            </button>
                                            <a href="/index.php/admin/user/add" class="btn btn-xs btn-success pull-right" data-toggle="modal" data-target="#add">添加用户</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="widget-box transparent ui-sortable-handle" id="widget-box-12">
                                <div class="widget-body">
                                    <div class="widget-main padding-6 no-padding-left no-padding-right">
                                        <?php
                                        $list = _G('list');
                                        ?>
                                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td width="5%">编号</td>
                                                <th>用户名</th>
                                                <th>手机号</th>
                                                <th>邮箱</th><?php //class="hidden-480"?>
                                                <th>省</th>
                                                <th>市</th>
                                                <th>最近登录时间</th>
                                                <th>最近登录ip</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($list && is_array($list)) {?>
                                                <?php $no = 1;?>
                                                <?php foreach($list as $item) {?>
                                                    <tr>
                                                        <td><?=$no++?></td>
                                                        <td><?=$item['cnickname']?></td>
                                                        <td><?=$item['cmobile']?></td>
                                                        <td><?=$item['cemail']?></td>
                                                        <td><?=$item['cprovince']?></td>
                                                        <td><?=$item['ccity']?></td>
                                                        <td><?=$item['ilast_login_time'] ? date('Y-m-d H:i:s', $item['ilast_login_time']) : ''?></td>
                                                        <td><?=$item['clast_login_ip'] ? $item['clast_login_ip'] : ''?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">
                                                            <a href="/index.php/admin/user/mod?uid=<?=$item['uid']?>" class="btn btn-xs btn-primary pull-right tr-btn-offset" data-toggle="modal" data-target="#mod">编辑</a>
                                                            <button class="btn btn-xs tr-btn-offset btn-info pull-right" data-uid="<?=$item['uid']?>" data-toggle="modal" data-target="#mod_avatar" data-avatar="<?=$item['avatar']?>">修改头像</button>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- PAGE CONTENT ENDS -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <?php _I('/view/admin/copyright.inc.php');?>
    <div class="modal fade in" id="add" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal fade in" id="mod" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <div class="modal fade in" id="mod_avatar" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">修改头像</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="/index.php/admin/user/mod_avatar">
                        <input type="hidden" name="uid">
                        <input type="hidden" name="old_avatar">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">头像</label>
                            <div class="col-xs-8">
                                <input multiple="false" name="avatar" type="file" id="id-input-file-3" />

                                <!-- /section:custom/file-input -->
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button data-bb-handler="cancel" type="button" class="btn btn-primary btn-apply">保存</button>
                    <button data-bb-handler="confirm" type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.main-container -->

<script src="/static/js/admin/distpicker.min.js"></script>
<script>
    $(function() {
        //添加用户
        $('#add').on('loaded.bs.modal', function() {
            $('[data-toggle="distpicker"]').distpicker();
            $(this).find('.btn-apply').click(function() {
                var $modal = $(this).parents('.modal').eq(0);
                var $form = $modal.find('form');
                var url = $form.attr('action');
                if($form.find('input[name="cnickname"]').val() == '') {
                    alert('请输入用户名');
                    return false;
                }
                if($form.find('input[name="pwd"]').val() == '') {
                    alert('请输入密码');
                    return false;
                }
                if($form.find('input[name="pwd"]').val().length < 6) {
                    alert('密码长度不能小于6位');
                    return false;
                }
                if($form.find('input[name="pwd"]').val() != $form.find('input[name="ckpwd"]').val()) {
                    alert('两次输入密码不一致，请重新输入');
                    return false;
                }
                if($form.find('input[name="cmobile"]').val() == '') {
                    alert('请输入手机号');
                    return false;
                }
                if(!/^[1][3,4,5,7,8][0-9]{9}$/.test($form.find('input[name="cmobile"]').val())) {
                    alert('请输入正确的手机号');
                    return false;
                }
                if($form.find('input[name="cemail"]').val() == '') {
                    alert('请输入邮箱');
                    return false;
                }
                if(!/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/.test($form.find('input[name="cemail"]').val())) {
                    alert('请输入正确的邮箱');
                    return false;
                }
                if($modal.find('select[name="cprovince"]').val() == '' || $modal.find('select[name="ccity"]').val() == '') {
                    alert('请选择省和市');
                    return false;
                }
                $.post(url, $form.serialize(), function(data) {
                    alert(data.msg);
                    if(data.errcode == 0) {
                        window.location.reload();
                    }
                }, 'json');
            });
        });
        $('#add').on('hidden.bs.modal', function() {
            $(this).removeData("bs.modal");
        });
        $('#mod').on('shown.bs.modal', function() {
            $('[data-toggle="distpicker"]').distpicker();
            $(this).find('.btn-apply').click(function() {
                var $modal = $(this).parents('.modal').eq(0);
                var $form = $modal.find('form');
                var url = $form.attr('action');

                if($form.find('input[name="cnickname"]').val() == '') {
                    alert('请输入用户名');
                    return false;
                }
                if($form.find('input[name="cmobile"]').val() == '') {
                    alert('请输入手机号');
                    return false;
                }
                if(!/^[1][3,4,5,7,8][0-9]{9}$/.test($form.find('input[name="cmobile"]').val())) {
                    alert('请输入正确的手机号');
                    return false;
                }
                if($form.find('input[name="cemail"]').val() == '') {
                    alert('请输入邮箱');
                    return false;
                }
                if(!/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/.test($form.find('input[name="cemail"]').val())) {
                    alert('请输入正确的邮箱');
                    return false;
                }
                if($modal.find('select[name="cprovince"]').val() == '' || $modal.find('select[name="ccity"]').val() == '') {
                    alert('请选择省和市');
                    return false;
                }
                $.post(url, $form.serialize(), function(data) {
                    alert(data.msg);
                    if(data.errcode == 0) {
                        window.location.reload();
                    }
                }, 'json');
            });
        });
        $('#mod').on('hidden.bs.modal', function() {
            $(this).removeData("bs.modal");
        });
        $('#id-input-file-3').ace_file_input({
            style:'well',
            btn_choose:'Drop files here or click to choose',
            btn_change:null,
            no_icon:'ace-icon fa fa-cloud-upload',
            droppable:true,
            whitelist:'gif|png|jpg|jpeg',
            blacklist:'exe|php',
            thumbnail:'large'//large | fit | small
            //,icon_remove:null//set null, to hide remove/reset button
            /**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
            /**,before_remove : function() {
						return true;
					}*/
            ,
            preview_error : function(filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function(){
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });
        $('#mod_avatar').on('show.bs.modal', function(e) {
            var $this = $(this);
            var $btn = $(e.relatedTarget);
            var old_avatar = $btn.data('avatar');
            var uid = $btn.data('uid');
            $this.find('input[name="uid"]').val(uid);
            $this.find('input[name="old_avatar"]').val(old_avatar);
            var img = old_avatar || '/static/images/admin/no-img.png';
            $('#id-input-file-3').ace_file_input('show_file_list', [{type: 'image', name: '', path: img},]);})
    });
    $('#mod_avatar .btn-apply').click(function() {
        var $modal = $(this).parents('.modal').eq(0);
        var $form = $modal.find('form').eq(0);
        var old_avatar = $form.find('input[name="old_avatar"]').val();
        var avatar = $form.find('input[name="avatar"]').val();
        if($modal.find('.ace-file-name img').length == 0) {
            alert('请选择头像');
            return false;
        }
        var data = new FormData($form[0]);
        var url = $form.attr('action');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data:data,
            processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            contentType : false, // 不设置Content-type请求头
            success : function(data){
                alert(data.msg);
                if(data.errcode == 0) {
                    window.location.reload();
                }
            },
            error : function(){ }
        })
    });
</script>
<!-- basic scripts -->
<?php _I('/view/admin/footer.inc.php');?>
