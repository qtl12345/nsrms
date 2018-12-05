<?php if (!defined('THINK_PATH')) exit();?><style>
    .add_user_table,.edituser_role_table{
        margin: 15px auto;
    }
    .add_user_table tr,.edituser_role_table tr{
        line-height: 45px;
    }
    .add_user_table tr td:nth-child(2){
        text-align:left;
        width:70%;
    }
    .dialog-button {
        text-align: center;
    }
</style>
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


<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'center',border:false">
        <!-- Begin of toolbar -->
        <div id="User-toolbar">
            <div class="wu-toolbar-button">
                <a href="#" class="easyui-linkbutton" iconCls="icon-add" id="adduser" onclick="openAdd()" plain="true">添加</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-lock" id="lock" onclick="batcheditStatus(1)" plain="true">批量锁定</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-lock" id="lock" onclick="batcheditStatus(0)" plain="true">批量解锁</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="searchuser()"
                   plain="true">刷新</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-edit" id="resetpwd" onclick="restallpwd()" plain="true">批量重置密码</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-back" onclick="removeTab()" plain="true">返回</a>
            </div>
            <div class="wu-toolbar-search">
                <label>用户名：</label><input class="easyui-textbox" type="text" id="username"name="username"
                                          data-options="prompt:'用户名'" style="width:240px"></input>
                <a href="#" class="easyui-linkbutton" iconCls="icon-search" id="queryuser" onclick="searchuser()">开始检索</a>
            </div>
        </div>
        <!-- End of toolbar -->
        <table id="User-datagrid" toolbar="#User-toolbar" class="easyui-datagrid">
        </table>
    </div>
</div>
<!-- Begin of easyui-dialog -->
<div id="user-dialog" class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'"
     style="width:400px; padding:10px;">
    <form id="user-add-form" method="post">
        <table class="add_user_table">
            <tr>
                <td width="60">用户名:</td>
                <td><input type="text"id="add_username" name="add_username" class="easyui-textbox" style="width:160px;height:25px;"/></td>
            </tr>
            <tr>
                <td>密码:</td>
                <td><input type="password"id="add_password" name="password" class="easyui-textbox" style="width:160px;height:25px;" /></td>
            </tr>
            <tr>
                <td>确认密码:</td>
                <td><input type="password" id="add_confirmpwd"name="confirmpwd" class="easyui-textbox" style="width:160px;height:25px;" /></td>
            </tr>
        </table>
    </form>
</div>
<!-- End of easyui-dialog -->
<!-- -->
<div id="edituserrole-dialog" class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'"
     style="width:400px; padding:10px;">
    <form id="edituser-role-form" method="post">
        <table class="edituser_role_table">
            <tr>
                <td width="100px">用户名称:</td>
                <td>
                    <input class="easyui-textbox" type="text" name="edituser_role_name" readonly="readonly" style="width:120px;height:25px;"></input>
                </td>
            </tr>
            <tr>
                <td>角色：</td>
                <td>
                    <input id="rolelist" name="rolelist"  style="width:180px;height:25px;"  class="easyui-combobox" >
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- -->
<script type="text/javascript">
    function searchuser() {
        username = $('#username').textbox('getText');
        $('#User-datagrid').datagrid({
            url: "<?php echo U('User/serarchuser','','');?>",
            rownumbers: true,
            pagination: true,
            fitColumns: true,
            fit: true,
            singleSelect: false,
            pageSize: 5,
            pageList: [5, 20, 50],
            remoteSort: true,
            multiSort: true,
            columns: [[
                    {field: 'ck', checkbox: "true"},
                    {field: 'user_id', title: 'ID', align: 'center', width: 40},
                    {field: 'user_name', title: '用户名', width: 60, align: 'center'},
                    {field: 'logintime', title: '最后登录时间', width: 150, align: 'center'},
                    {field: 'loginip', title: '最后登录IP', width: 70, align: 'center'},
                    {field: 'lock', title: '账号状态', width: 60, align: 'center', formatter: showLock},
                    {field: 'operation', title: '操作', width: 180, align: 'center', formatter: showUserOptBtn}
                ]],
            queryParams: {
                "username": username
            }
        });
    }
    //显示状态
    function showLock(value, row, index) {
        if (value == 0) {
            return "正常";
        } else {
            return "锁定";
        }
    }

    //显示操作按钮
    function showUserOptBtn(value, row, index) {
        //按条件显示相应按钮
        if (row['lock'] == 0) {
            return "<a href='#' onclick='resetpwd(" + index + ")' class='easyui-linkbutton'id='resetpwd' name='pwd'>重置密码</a>&nbsp;" +
                    "<a href='#' onclick='editStatus(" + index + ")'class='easyui-linkbutton' id='lock' name='lock'>锁定用户</a>";
        } else {
            return "<a href='#' onclick='resetpwd(" + index + ")'class='easyui-linkbutton' id='resetpwd' name='pwd'>重置密码</a>&nbsp;" +
                    "<a href='#' onclick='editStatus(" + index + ")'class='easyui-linkbutton' id='lock' name='lock'>解除锁定</a>";
        }
    }
    function editStatus(rowIndex) {
        selectedRowIndex = $('#User-datagrid').datagrid('getRowIndex', $('#User-datagrid').datagrid('getSelected'));
        //判断当前按钮所在行与当前选中行是否一致
        if (rowIndex == selectedRowIndex) {
            row = $('#User-datagrid').datagrid('getSelected');
            if (row) {
                $.ajax({
                    url: "<?php echo U('User/editUserStatus','','');?>",
                    type: "post",
                    dataType: "json",
                    data: {"ids": row['user_id'], "lock": row['lock']},
                    success: function (result) {
                        $.messager.show({
                            title: '系统提示',
                            msg: result
                        });
                        $('#User-datagrid').datagrid('reload');
                    }
                });
            }
        }
    }
    function resetpwd(rowIndex) {
        selectedRowIndex = $('#User-datagrid').datagrid('getRowIndex', $('#User-datagrid').datagrid('getSelected'));
        //判断当前按钮所在行与当前选中行是否一致
        if (rowIndex == selectedRowIndex) {
            row = $('#User-datagrid').datagrid('getSelected');
            if (row) {
                $.ajax({
                    url: "<?php echo U('User/resetpwd','','');?>",
                    type: "post",
                    dataType: "json",
                    data: {"ids": row['user_id']},
                    success: function (result) {
                        $.messager.show({
                            title: '系统提示',
                            msg: result
                        });
                        $('#User-datagrid').datagrid('reload');
                    }
                });
            }
        }
    }
    function openAdd() {
        $('#user-add-form').form('clear');
        $('#user-dialog').dialog({
            closed: false,
            modal: true,
            top: 40,
            title: "添加用户",
            buttons: [{
                    text: '确定',
                    iconCls: 'icon-ok',
                    handler: addUser
                }, {
                    text: '取消',
                    iconCls: 'icon-cancel',
                    handler: function () {
                        $('#user-dialog').dialog('close');
                    }
                }]
        });
    }
    function addUser() {
        if ($.trim($('input[textboxname=add_username]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "用户名没有填写"
            });
            $('input[textboxname=add_username]').textbox().next('span').find('input').focus();
            return;
        }

        if ($.trim($('input[textboxname=password]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "密码没有填写"
            });
            $('input[textboxname=password]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=confirmpwd]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "确认密码没有填写"
            });
            $('input[textboxname=confirmpwd]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=confirmpwd]').textbox('getValue')) != $.trim($('input[textboxname=password]').textbox('getValue'))) {
            $.messager.show({
                title: '系统提示',
                msg: "密码与确认密码不一致"
            });
            $('input[textboxname=confirmpwd]').textbox().next('span').find('input').focus();
            return;
        }
        addusername = $('#add_username').textbox('getText');
        adduserpassword = $('#add_password').textbox('getText');
        add_confirmpwd = $('#add_confirmpwd').textbox('getText');
        $.ajax({
            url: "<?php echo U('User/adduser','','');?>",
            type: "post",
            async: false,
            dataType: "json",
            data: {"addusername": addusername, "add_confirmpwd": add_confirmpwd},
            success: function (result) {
                $.messager.show({
                    title: '系统提示',
                    msg: result
                });
                $('#user-dialog').dialog('close');
                $('#User-datagrid').datagrid('reload');
            }
        });
    }
    function batcheditStatus(lock) {
        rows = $('#User-datagrid').datagrid('getSelections');
        if (rows.length == 0) {
            $.messager.show({
                title: '系统提示',
                msg: '请先选择要操作的数据'
            });
            return;
        }
        ids = [];
        for (i = 0; i < rows.length; i++)
        {
            ids.push(rows[i]['user_id']);
        }
        $.ajax({
            url: "<?php echo U('User/edituser','','');?>",
            type: "post",
            dataType: "json",
            data: {"ids": ids, "lock": lock},
            success: function (result) {
                $.messager.show({
                    title: '系统提示',
                    msg: result
                });
                $('#User-datagrid').datagrid('reload');
            }
        });
    }
    function restallpwd() {
        rows = $('#User-datagrid').datagrid('getSelections');
        if (rows.length == 0) {
            $.messager.show({
                title: '系统提示',
                msg: '请先选择要操作的数据'
            });
            return;
        }
        ids = [];
        for (i = 0; i < rows.length; i++)
        {
            ids.push(rows[i]['user_id']);
        }
        $.ajax({
            url: "<?php echo U('User/resetpwd','','');?>",
            type: "post",
            dataType: "json",
            data: {"ids": ids, "datatype": 111},
            success: function (result) {
                $.messager.show({
                    title: '系统提示',
                    msg: result
                });
                $('#User-datagrid').datagrid('reload');
            }
        });
    }
</script>