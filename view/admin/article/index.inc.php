<?php _I('/view/admin/header.inc.php');?>
<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <!-- #section:basics/sidebar -->
    <?php _I('/view/admin/leftside.inc.php');?>
    <?php $ichannel = _G('ichannel');?>
    <?php $itype = _G('itype');?>
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
                                                <label class="sr-only" for="kword">关键字</label>
                                                <input type="text" name="kword" value="<?=_P('kword')?>" class="form-control" id="kword" placeholder="请输入关键字">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="ichannel">频道</label>
                                                <select name="ichannel" class="form-control" id="ichannel">
                                                    <option value="">请选择频道</option>
                                                    <?php foreach(\modal\admin\Article::channels() as $k => $v) {?>
                                                        <option value="<?=$k?>" <?=$ichannel == $k ? 'selected':''?>><?=$v?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="itype">类别</label>
                                                <select name="itype" class="form-control" id="itype">
                                                    <option value="">请选择类别</option>
                                                    <?php foreach(\modal\admin\Article::types($ichannel) as $k => $v) {?>
                                                        <option value="<?=$k?>" <?=$itype == $k ? 'selected':''?>><?=$v?></option>
                                                    <?php }?>
                                                </select>
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
                                                <th>标题</th>
                                                <th>作者</th>
                                                <th>摘要</th><?php //class="hidden-480"?>
                                                <th>创建时间</th>
                                                <th>更新时间</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if($list && is_array($list)) {?>
                                                <?php $no = 1;?>
                                                <?php foreach($list as $item) {?>
                                                    <tr>
                                                        <td><?=$no++?></td>
                                                        <td><?=$item['ctitle']?></td>
                                                        <td><?=$item['user']['cnickname']?></td>
                                                        <td><?=$item['cabstract']?></td>
                                                        <td><?=date('Y-m-d H:i:s', $item['itime'])?></td>
                                                        <td><?=date('Y-m-d H:i:s', $item['update_time'])?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">
                                                            <a href="/index.php/admin/user/mod?uid=<?=$item['uid']?>" class="btn btn-xs btn-primary pull-right tr-btn-offset" data-toggle="modal" data-target="#mod">编辑</a>
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
</div><!-- /.main-container -->

<script src="/static/js/admin/distpicker.min.js"></script>
<script>
    $(function() {
        //添加用户
    })
</script>
<!-- basic scripts -->
<?php _I('/view/admin/footer.inc.php');?>
