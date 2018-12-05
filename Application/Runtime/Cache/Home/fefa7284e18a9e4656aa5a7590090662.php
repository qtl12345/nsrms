<?php if (!defined('THINK_PATH')) exit();?><link href="/Nsrms/Public/uploaddify/uploadify.css" rel="stylesheet" type="text/css"/>
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


<style>
    .edit_major_table{
        margin: 15px auto;
    }
    .edit_major_table tr{
        line-height: 45px;
    }
    .dialog-button {
        text-align: center;
    }
</style>
<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'center',border:false">
        <!-- Begin of toolbar -->
        <div id="Major-toolbar">
            <div class="wu-toolbar-button">
                <a class="easyui-linkbutton" href="#" iconcls="icon-add" id="addmajor" onclick="openAddMajor(-1)" plain="true">
                    添加
                </a>
                <a class="easyui-linkbutton" href="#" iconcls="icon-reload" onclick="searchMajorGrid()" plain="true">
                    刷新
                </a>
                <a class="easyui-linkbutton" href="#" iconcls="icon-back" onclick="removeTab()" plain="true">
                    返回
                </a>
            </div>
            <div class="wu-toolbar-search">
                <label>
                    院系名称：
                </label>
                <select class="easyui-combobox" editable="false" id="department" name="edit_q_department"
                        panelheight="auto" style="width:160px;">
                    <option value="-1">请选择</option>
                </select>
                <label>
                    专业名称：
                </label>
                <select class="easyui-combobox"editable="false" panelheight="auto" id="major" name="major" style="width:160px;">
                    <option value="-1">请选择</option>
                </select>
                <a class="easyui-linkbutton" href="#" iconcls="icon-search" id="major" onclick="searchMajorGrid()">
                    开始检索
                </a>
            </div>
        </div>
        <!-- End of toolbar -->
        <table id="Major-datagrid" class="easyui-datagrid" toolbar="#Major-toolbar">
        </table>
    </div>
</div>
<!-- Begin of easyui-dialog -->
<div class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'" id="major-dialog" style="width:400px; padding:10px;">
    <form id="major-edit-form" method="post">
        <table class="edit_major_table">
            <tr>
                <td >
                    院系名称:
                </td>
                <td>
                    <input class="easyui-textbox"  id="add_department"name="add_majorname" style="width:160px;height:25px;" type="text"/>
                </td>
            </tr> 
            <tr>
                <td >
                    专业名称:
                </td>
                <td>
                    <input class="easyui-textbox" id="add_majorname"name="add_majorname" style="width:160px;height:25px;" type="text"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<div class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'" id="add-dialog" style="width:400px; padding:10px;">
    <form id="major-edit-form" method="post">
        <table class="edit_major_table">
            <tr>
                <td >
                    院系名称:
                </td>
                <td>
                    <select class="easyui-combobox" editable="false" id="department_name" name="department" panelheight="auto" style="width:160px;">
                        <option value="-1">请选择</option>
                    </select>
                </td>
            </tr> 
            <tr>
                <td >
                    专业名称:
                </td>
                <td>
                    <input class="easyui-textbox" id="major_name"name="major_name" style="width:160px;height:25px;" type="text"/>
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- End of easyui-dialog -->
<script type="text/javascript">
    var zymc = ''
    var zyid = ''
    function Loaddep() {
        $.ajax({
            url: "<?php echo U('Registration/select','','');?>",
            data: {"data": 1},
            method: "post",
            dataType: "json",
            async: false,
            success: function (data) {
                var combx = [{'text': '请选择', 'value': '-1'}];
                for (i = 0; i < data.length; i++) {
                    combx.push({"text": data[i].xbmc, "value": data[i].xbdm});
                }
                $("#department_name").combobox("loadData", combx);
            }
        });
    }
    function searchMajorGrid() {
        var department = $('#department').combobox('getValue');
        var major = $('#major').combobox('getValue');
        $('#Major-datagrid').datagrid({
            queryParams: {
                "department": department,
                "major": major
            },
            url: "<?php echo U('BaseData/getMajorByPageUrl','','');?>",
            rownumbers: true,
            pagination: true,
            fitColumns: true,
            singleSelect: true,
            fit: true,
            pageSize: 10,
            pageList: [10, 50, 100],
            remoteSort: true,
            multiSort: true,
            columns: [[
                    {field: 'zydm', align: "center", title: "编号", width: 100},
                    {field: 'xbdm', align: "center", title: "院系编号", width: 100, hidden: 'true'},
                    {field: 'xbmc', align: "center", title: "院系名称", width: 100},
                    {field: 'zymc', align: "center", title: "专业名称", width: 100},
                    {field: 'opt', align: "center", title: "操作", width: 80, formatter: showMajorOptBtn}
                ]]
        });
    }
    function showMajorOptBtn(value, row, index) {
        return "<a href='#' onclick='editMajor(" + index + ")' class='easyui-linkbutton' id='editMajor' name='editMajor'>编辑</a>";
    }



    function editMajor(rowIndex) {
        console.log(rowIndex);
        //获取当前选中行的索引
        selectedRowIndex = $('#Major-datagrid').datagrid('getRowIndex', $('#Major-datagrid').datagrid('getSelected'));
        //判断当前按钮所在行与当前选中行是否一致
        console.log(selectedRowIndex);
        if (rowIndex == selectedRowIndex) {
            row = $('#Major-datagrid').datagrid('getSelected');
            if (row) {
                $('#add_department').textbox('readonly', true);
                zymc = row['zymc'];
                zyid = row['zydm'];
                $('#add_majorname').textbox('setValue',row['zymc']);
                $('#add_department').textbox('setValue',row['xbmc']);
                $('#major-dialog').dialog({
                    closed: false,
                    modal: true,
                    title: "编辑专业",
                    top: 30,
                    buttons: [{
                            text: '确定',
                            iconCls: 'icon-ok',
                            handler: doSaveMajor
                        }, {
                            text: '取消',
                            iconCls: 'icon-cancel',
                            handler: function () {
                                $('#major-dialog').dialog('close');
                            }
                        }]
                });
            }
        }
    }
    function doSaveMajor() {
        //提交前检查名字是否重复
        former = $("#add_majorname").textbox("getValue");
        if (zymc != former && former != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveMajor','','');?>",
                data: {"zyid": zyid, "ynamme": former, "zymc": zymc, "datatype": 111},
                type: "post",
                dataType: "json",
                success: function (data) {
                    if (data >= 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '修改成功'
                        });
                        $('#major-dialog').dialog('close');
                        $('#Major-datagrid').datagrid('reload');
                    }
                },
            });
        } else {
            $.messager.show({
                title: '系统提示',
                msg: '专业名称重复或为空'
            });
        }
    }

    function openAddMajor() {
        $('#add_department').textbox('readonly', false);
        Loaddep();
        $('#add-dialog').dialog({
            closed: false,
            modal: true,
            title: "添加专业",
            top: 30,
            buttons: [{
                    text: '确定',
                    iconCls: 'icon-ok',
                    handler: addSavemajorOK
                }, {
                    text: '取消',
                    iconCls: 'icon-cancel',
                    handler: function () {
                        $('#add-dialog').dialog('close');
                    }
                }]
        });
    }
    function addSavemajorOK() {
        var dep = $('#department_name').combobox('getValue');
        var maj = $('#major_name').textbox('getValue');
        if (dep != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveMajor','','');?>",
                data: {"add_major": maj, "datatype": 110, "add_dep": dep},
                type: "post",
                dataType: "json",
                //提交成功后的回调函数
                success: function (data) {
                    if (data > 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '添加成功'
                        });
                        $('#add-dialog').dialog('close');
//                        $('#Department-datagrid').datagrid('reload');
                        $('#Major-datagrid').datagrid('reload');
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
    $(function () {
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
                $('#department').combobox({
                    onChange: function () {
                        var yxvalue = $('#department').combobox('getValue');
                        if (yxvalue != -1 && yxvalue != '请选择') {
                            $.ajax({
                                url: "<?php echo U('Registration/select','','');?>",
                                data: {"data": "2", "datatype": yxvalue},
                                method: "POST",
                                dataType: "json",
                                success: function (data) {
                                    var themecombo2 = [{'zymc': '请选择', 'zydm': '-1'}];
                                    for (var i = 0; i < data.length; i++) {
                                        themecombo2.push({"zymc": data[i].zymc, "zydm": data[i].zydm});
                                    }
                                    $('#major').combobox({
                                        data: themecombo2,
                                        valueField: 'zydm',
                                        textField: 'zymc'
                                    });
                                }
                            });
                        } else {
                            $('#major').combobox('loadData', {});
                            $('#major').combobox('setValue', '-1');//一定要先value后text,否则text与value值会相同全为value值  
                            $('#major').combobox('setText', '请选择');

                        }
                    }
                });
            }
        }
        );
    });
</script>