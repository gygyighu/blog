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
                    <form class="form-horizontal" id="article_form" action="/index.php/admin/article/padd" method="post" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="form-group">
                            <label for="ichannel" class="col-sm-2 control-label">频道</label>
                            <div class="col-sm-8">
                                <select name="ichannel" id="ichannel" class="form-control">
                                    <option value="">请选择频道</option>
                                    <?php foreach(\modal\admin\Article::channels() as $k => $v) {?>
                                        <option value="<?=$k?>"><?=$v?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="itype" class="col-sm-2 control-label">类别</label>
                            <div class="col-sm-8">
                                <select name="itype" id="itype" class="form-control">
                                    <option value="">请选择类别</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ctitle" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-8">
                                <input type="text" name="ctitle" class="form-control" id="ctitle" placeholder="请输入标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="csubtitle" class="col-sm-2 control-label">副标题</label>
                            <div class="col-sm-8">
                                <input type="text" name="csubtitle" class="form-control" id="csubtitle" placeholder="请输入副标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cauthor" class="col-sm-2 control-label">作者</label>
                            <div class="col-sm-8">
                                <input type="text" name="cauthor" class="form-control" id="cauthor" placeholder="请输入作者">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cabstract" class="col-sm-2 control-label">摘要</label>
                            <div class="col-sm-8">
                                <input type="text" name="cabstract" class="form-control" id="cabstract" placeholder="请输入摘要">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clogo" class="col-sm-2 control-label">封面</label>
                            <div class="col-xs-8">
                                <input multiple="false" name="clogo" type="file" id="clogo" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ccontent" class="col-sm-2 control-label">内容</label>
                            <div class="col-xs-8">
                                <textarea name="ccontent" id="ccontent" cols="30" rows="10" class="form-control" placeholder="请输入内容"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ishow" class="col-sm-2 control-label">是否公开</label>
                            <div class="col-xs-3">
                                <label>
                                    <input name="ishow" id="ishow" value="1" class="ace ace-switch ace-switch-4" type="checkbox" />
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-success apply" data-opration="1">保存为草稿</button>
                                <button type="submit" class="btn btn-primary apply" data-opration="2">发布</button>
                                <button type="button" class="btn btn-default" onclick="history.go(-1)">取消</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <?php _I('/view/admin/copyright.inc.php');?>
</div><!-- /.main-container -->

<script src="/static/js/admin/distpicker.min.js"></script>
<script>
    $(function() {
        //添加用户
        $('#ichannel').change(function() {
            var ichannel = $(this).val();
            $.get('/index.php/admin/article/gettypes', {ichannel:ichannel}, function(data) {
                var str = '<option value="">请选择类别</option>';
                if(data.errcode == 0) {
                    var list = data.data.types;
                    for(var i in list) {
                        str += '<option value="' + i + '">' + list[i] + '</option>';
                    }
                }
                $('#itype').html(str);
            }, 'json')
        });
        $('#clogo').ace_file_input({
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

        //保存文章
        $('.apply').click(function() {
            $opration = $(this).data('opration');
            var data = new FormData($('#article_form')[0]);
            data.append('operation', $opration);
            var url = $('#article_form').attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
                contentType : false, // 不设置Content-type请求头
                success: function (data) {
                    alert(data.msg);
                    if(data.errcode == 0) {
                        window.location.href = '/index.php/admin/article/index';
                    }
                }
            });
        });
    })
</script>
<!-- basic scripts -->
<?php _I('/view/admin/footer.inc.php');?>