<?php if (!defined('THINK_PATH')) exit();?><div style="width:700px;height:300px;padding:10px;margin:30px auto;">
    <div class="easyui-panel" title="">
        <form id="editpassword" method="post"enctype="multipart/form-data" class="jsrz_main_information">
            <table cellpadding="5" style="margin:30px auto;">
                <tr>
                    <td>原始密码:</td>
                    <td>
                        <input class="easyui-textbox" type="password"id="oldpassword" name="oldpassword" style="width:240px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>新密码:</td>
                    <td>
                        <input  class="easyui-textbox" type="password"id="newpassword" name="newpassword"  style="width:240px;"></input>
                    </td>
                </tr>
                <tr>
                    <td>确认密码:</td>
                    <td>
                        <input class="easyui-textbox" type="password" id="repassword"name="repassword"  style="width:240px;"></input>
                    </td>
                </tr>
            </table>
            <div style="text-align:center;padding:5px">
                <button style="text-align:center;" onclick="save()"type="button" class="easyui-linkbutton" data-options="iconCls:'icon-save'" id="editpwd" >修改</button>
            </div>
        </form>
    </div>
</div>
<script>
    function save() {
        $.ajax(//ajax方式提交表单  
                {
                    url: "<?php echo U('User/editpwde','','');?>",
                    data: $('#editpassword').serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        if (data == '密码修改成功,即将推出系统!') {
                            $.messager.show({
                                title: '提示消息',
                                msg: data,
                                timeout: 2000,
                                showType: 'slide'
                            });
                            setTimeout("top.location='<?php echo U('Login/exits','','');?>'", 2000);
                        } else {
                            $.messager.show({
                                title: '提示消息',
                                msg: data,
                                timeout: 2000,
                                showType: 'slide'
                            });
                        }
                        $("#oldpassword").textbox('setValue', '');
                        $("#newpassword").textbox('setValue', '');
                        $("#repassword").textbox('setValue', '');
                    }
                });
    }
</script>
<link href="/Nsrms/Public/uploaddify/uploadify.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo EASYUI ?>/themes/default/easyui.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS ?>/wu.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS ?>/icon.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo JS ?>/jquery-3.2.0.min.js" type="text/javascript">
</script>
<script src="/Nsrms/Public/uploaddify/jquery.uploadify.min.js" type="text/javascript" >
</script>
<!--<script src="/Nsrms/Public/uploaddify/jquery.uploadify.js" type="text/javascript">
</script>-->
<!--<script src="<?php echo UPLOADIFY ?>/jquery.uploadify.min.js" type="text/javascript">
</script>-->
<script src="<?php echo EASYUI ?>/jquery.easyui.min.js" type="text/javascript">
</script>
<script src="<?php echo EASYUI ?>/locale/easyui-lang-zh_CN.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/jquery.form.min.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/aaa.js" type="text/javascript">
</script>