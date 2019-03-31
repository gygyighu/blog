<?php _I('/view/admin/header.inc.php');?>
<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <!-- #section:basics/sidebar -->
    <?php _I('/view/admin/leftside.inc.php');?>

    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                                $list = $this->getTempVal('list');
                            ?>
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td>编号</td>
                                    <th>用户名</th>
                                    <th>手机号</th>
                                    <th>邮箱</th><?php //class="hidden-480"?>
                                    <th>省</th>
                                    <th>市</th>
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
                                            </tr>
                                        <?php }?>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div><!-- /.span -->
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <?php _I('/view/admin/copyright.inc.php');?>
</div><!-- /.main-container -->

<!-- basic scripts -->
<?php _I('/view/admin/footer.inc.php');?>
