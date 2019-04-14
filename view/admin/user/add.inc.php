<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">添加用户</h4>
</div>
<div class="modal-body">
    <form class="form-horizontal" action="/index.php/admin/user/add">
        <input type="hidden" name="do" value="1">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" name="cnickname"  class="form-control" id="cnickname" placeholder="请输入用户名">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" name="ckpwd" class="form-control" id="ckpwd" placeholder="请输入确认密码">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">手机号</label>
            <div class="col-sm-10">
                <input type="tel" name="cmobile" class="form-control" id="cmobile" placeholder="请输入手机号">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>
            <div class="col-sm-10">
                <input type="email" name="cemail" class="form-control" id="cemail" placeholder="请输入邮箱">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">角色</label>
            <div class="col-sm-10">
                <select name="irole" id="irole" class="form-control">
                    <option value="">请选择角色</option>
                    <?php foreach (\modal\admin\User::user_roles() as $k => $v) {?>
                        <option value="<?=$k?>"><?=$v?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="cprovince" class="col-sm-2 control-label">区域</label>
            <div class="col-sm-10 dist" data-toggle="distpicker">
                <select name="cprovince" class="form-control" style="width: auto;display: inline-block;" id="cprovince"></select>
                <select name="ccity" id="ccity" class="form-control" style="width: auto;display: inline-block;"></select>
                <input type="text" class="form-control" id="caddress" name="caddress" placeholder="详细地址" style="margin-top: 10px;">
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button data-bb-handler="cancel" type="button" class="btn btn-primary btn-apply">保存</button>
    <button data-bb-handler="confirm" type="button" class="btn btn-default" data-dismiss="modal">取消</button>
</div>