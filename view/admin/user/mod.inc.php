<?php $item = _G('item');?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">编辑用户</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" action="/index.php/admin/user/pmod" method="post" enctype="multipart/form-data">
        <input type="hidden" name="do" value="1">
        <input type="hidden" name="uid" value="<?=$item['uid']?>">
        <div class="form-group">
            <label for="cnickname" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" name="cnickname"  class="form-control" id="cnickname" value="<?=$item['cnickname']?>" placeholder="请输入用户名">
            </div>
        </div>
        <div class="form-group">
            <label for="gender" class="col-sm-2 control-label">性别</label>
            <div class="col-sm-10">
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender" value="1" <?=$item['gender'] == 1 ? 'checked':''?>> 男
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender1" value="2" <?=$item['gender'] == 2 ? 'checked':''?>> 女
                </label>
                <label class="radio-inline">
                    <input type="radio" name="gender" id="gender2" value="3" <?=$item['gender'] == 3 ? 'checked':''?>> 保密
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="cmobile" class="col-sm-2 control-label">手机号</label>
            <div class="col-sm-10">
                <input type="tel" name="cmobile" class="form-control" value="<?=$item['cmobile']?>" id="cmobile" placeholder="请输入手机号">
            </div>
        </div>
        <div class="form-group">
            <label for="cemail" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
                <input type="email" name="cemail" class="form-control" value="<?=$item['cemail']?>" id="cemail" placeholder="请输入邮箱">
            </div>
        </div>
        <div class="form-group">
            <label for="irole" class="col-sm-2 control-label">角色</label>
            <div class="col-sm-10">
                <select name="irole" id="irole" class="form-control">
                    <option value="">请选择角色</option>
                    <?php foreach (\modal\admin\User::user_roles() as $k => $v) {?>
                        <option value="<?=$k?>" <?=$item['irole'] == $k ? 'selected' : ''?>><?=$v?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="cprovince" class="col-sm-2 control-label">区域</label>
            <div class="col-sm-10 dist" data-toggle="distpicker">
                <select data-province="<?=$item['cprovince']?>"  name="cprovince" class="form-control" style="width: auto;display: inline-block;" id="cprovince"></select>
                <select data-city="<?=$item['ccity']?>" name="ccity" id="ccity" class="form-control" style="width: auto;display: inline-block;"></select>
                <input type="text" class="form-control" value="<?=$item['caddress']?>" id="caddress" name="caddress" placeholder="详细地址" style="margin-top: 10px;">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button data-bb-handler="cancel" type="button" class="btn btn-primary btn-apply">保存</button>
    <button data-bb-handler="confirm" type="button" class="btn btn-default" data-dismiss="modal">取消</button>
</div>