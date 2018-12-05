<?php if (!defined('THINK_PATH')) exit();?><link href="/Nsrms/Public/css/seat.css" rel="stylesheet" type="text/css"/>
<style>
    .edit_department_table{
        margin: 15px auto;
    }
    .edit_department_table tr{
        line-height: 45px;
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
        <div id="Deparment-toolbar">
            <div class="wu-toolbar-button">
                <a class="easyui-linkbutton" href="#" iconcls="icon-add" id="adddepartment" onclick="openAddDepartment()" plain="true">
                    添加
                </a>
                <a class="easyui-linkbutton" href="#" iconcls="icon-reload" onclick="searchon()" plain="true">
                    刷新
                </a>
                <a class="easyui-linkbutton" href="#" iconcls="icon-back" onclick="" plain="true">
                    返回
                </a>
            </div>
            <div class="wu-toolbar-search">
                <label>
                    院系名称：
                </label>
                <select class="easyui-combobox" editable="false" id="department" name="department" panelheight="auto" style="width:160px;">
                    <option value="-1">请选择</option>
                </select>
                <a class="easyui-linkbutton" href="#" iconcls="icon-search" id="querydepartment" onclick="searchon()">
                    开始检索
                </a>
            </div>
        </div>
        <!-- End of toolbar -->
        <table id="Department-datagrid" class="easyui-datagrid" toolbar="#Department-toolbar">
        </table>
    </div>
</div>
<!-- Begin of easyui-dialog -->
<div class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'" id="department-dialog" style="width:400px; padding:10px;">
    <form id="department-edit-form" method="post">
        <table class="edit_department_table" >
            <tr>
                <td>
                    院系名称:
                </td>
                <td>
                    <input class="easyui-textbox"id="add_department" name="add_department" style="width:160px;height:25px;" type="text"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- End of easyui-dialog -->
<script type="text/javascript">
    var yxmc = ''
    var xbid = ''
    function searchon() {
        var departmentname = $('#department').combobox('getText');
        $('#Department-datagrid').datagrid({
            queryParams: {
                "departmentname": departmentname,
            },
            url: "<?php echo U('BaseData/getDepartmentByPageUrl','','');?>",
            rownumbers: true,
            pagination: true,
            fitColumns: true,
            singleSelect: true,
            pageSize: 10,
            pageList: [10, 50, 100],
            remoteSort: true,
            multiSort: true,
            columns: [[
                    {field: 'xbdm', align: "center", title: "编号", width: 100},
                    {field: 'xbmc', align: "center", title: "院系名称", width: 100},
                    {field: 'opt', align: "center", title: "操作", width: 100, formatter: showDepartmentOptBtn}
                ]]
        });
    }

    function showDepartmentOptBtn(value, row, index) {
        return "<a href='#' onclick='editDepartment(" + index + ")' class='easyui-linkbutton' id='editDepartment' name='editDepartment'>编辑</a>";
    }
    function editDepartment(rowIndex) {
        //获取当前选中行的索引
        selectedRowIndex = $('#Department-datagrid').datagrid('getRowIndex', $('#Department-datagrid').datagrid('getSelected'));
        //判断当前按钮所在行与当前选中行是否一致
        if (rowIndex == selectedRowIndex) {
            row = $('#Department-datagrid').datagrid('getSelected');
            if (row) {
                yxmc = row['xbmc'];
                xbid = row['xbdm'];
                $('#add_department').textbox('setValue', row['xbmc']);
                $('#department-dialog').dialog({
                    closed: false,
                    modal: true,
                    title: "编辑院系",
                    top: 30,
                    buttons: [{
                            text: '确定',
                            iconCls: 'icon-ok',
                            handler: doSaveDepartment
                        }, {
                            text: '取消',
                            iconCls: 'icon-cancel',
                            handler: function () {
                                $('#department-dialog').dialog('close');
                            }
                        }]
                });
            }
        }
    }
    function doSaveDepartment() {
        //检查名称是否重复
        former = $("#add_department").textbox("getValue");
        if (yxmc != former && former != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveDepartmentUrl','','');?>",
                data: {"xbid": xbid, "ynamme": former, "xbmc": yxmc, "datatype": 111},
                type: "post",
                dataType: "json",
                //提交成功后的回调函数
                success: function (data) {
                    if (data >= 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '修改成功'
                        });
                        $('#department-dialog').dialog('close');
                        $('#Department-datagrid').datagrid('reload');
                    }
                },
            });
        } else {
            $.messager.show({
                title: '系统提示',
                msg: '请输入正确的名称'
            });
        }
    }

    function openAddDepartment() {
        $('#department-edit-form').form('clear');
        $('#department-dialog').dialog({
            closed: false,
            modal: true,
            title: "添加院系",
            top: 30,
            buttons: [{
                    text: '确定',
                    iconCls: 'icon-ok',
                    handler: SaveDepartmentOK
                }, {
                    text: '取消',
                    iconCls: 'icon-cancel',
                    handler: function () {
                        $('#department-dialog').dialog('close');
                    }
                }]
        });
    }
    function SaveDepartmentOK() {
        add_dep = $("#add_department").textbox("getValue");
        if (add_dep != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveDepartmentUrl','','');?>",
                data: {"add_dep": add_dep, "datatype": 110},
                type: "post",
                dataType: "json",
                //提交成功后的回调函数
                success: function (data) {
                    if (data > 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '添加成功'
                        });
                        $('#department-dialog').dialog('close');
                        $('#Department-datagrid').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: '系统提示',
                            msg: data
                        });
                    }
                },
            });
        }
    }
    $.ajax({
        url: "<?php echo U('Registration/select','','');?>",
        data: {"data": 1},
        method: "post",
        dataType: "json",
        async: false,
        success: function (datad) {
            for (i = 0; i < datad.length; i++) {
                $("#department").append('<option value=' + datad[i].xbdm + '>' + datad[i].xbmc + '</option>');
            }
        }
    });
</script>