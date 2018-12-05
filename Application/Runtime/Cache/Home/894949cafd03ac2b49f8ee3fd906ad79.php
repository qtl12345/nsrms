<?php if (!defined('THINK_PATH')) exit();?><style>
    .edit_dorm_table{
        margin: 15px auto;
    }
    .edit_dorm_table tr{
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
        <div id="Dorm-toolbar">
            <div class="wu-toolbar-button">
                <a class="easyui-linkbutton" href="#" iconcls="icon-add" id="adddorm" onclick="openAddDorm()" plain="true">
                    添加
                </a>
                <a class="easyui-linkbutton" href="#" iconcls="icon-reload" onclick="searchDormGrid()" plain="true">
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
                <select class="easyui-combobox" editable="false" id="q_department" name="q_department"
                        panelheight="auto" style="width:160px;">
                    <option value="-1">请选择</option>
                </select>
                <label>
                    寝室名称：
                </label>
                <input class="easyui-textbox" data-options="prompt:'寝室名称'" id="q_dorm"name="dormname" style="width:240px" type="text"/>
                <a class="easyui-linkbutton" href="#" iconcls="icon-search" id="querydorm" onclick="searchDormGrid()">
                    开始检索
                </a>
            </div>
        </div>
        <!-- End of toolbar -->
        <table id="Dorm-datagrid" class="easyui-datagrid" toolbar="#Dorm-toolbar">
        </table>
    </div>
</div>
<!-- Begin of easyui-dialog -->
<div class="easyui-dialog" data-options="closed:true,iconCls:'icon-save'" id="dorm-dialog" style="width:400px; padding:10px;">
    <form id="dorm-edit-form" method="post">
        <table class="edit_dorm_table">
            <tr>
                <td >
                    所属院系:
                </td>
                <td>
                    <select class="easyui-combobox" editable="false" id="edit_d_department" name="edit_d_department"
                            panelheight="auto" style="width:160px;height:25px;">
                        <option value="-1">请选择</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td >
                    寝室名称:
                </td>
                <td>
                    <input class="easyui-textbox" id="add_dormname"name="add_dormname" style="width:160px;height:25px;" type="text"/>
                </td>
            </tr>
            <tr>
                <td >
                    寝室类别:
                </td>
                <td>
                    <select class="easyui-combobox" editable="false" id="edit_d_sex" name="edit_d_sex"
                            panelheight="auto" style="width:160px;height:25px;">
                        <option value="-1">请选择</option>
                        <option value="0">男</option>
                        <option value="1">女</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="60">
                    寝室规格:
                </td>
                <td>
                    <select class="easyui-combobox" editable="false" id="edit_d_spec" name="edit_d_sex"
                            panelheight="auto" style="width:160px;height:25px;">
                        <option value="-1">请选择</option>
                        <option value="2">2</option>
                        <option value="4">4</option>
                        <option value="6">6</option>
                        <option value="8">8</option>
                    </select>
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- End of easyui-dialog -->
<script type="text/javascript">
    var xbmc = '';
    var dormvalue = '';
    var dclass = '';
    var spec = '';
    var xbid = '';
//    var comb = [{'text': '请选择', 'value': '-1'}];
    ;
    function searchDormGrid() {
        var departid = $('#q_department').combobox('getValue');
        var dormname = $('#q_dorm').textbox('getText');
        $('#Dorm-datagrid').datagrid({
            queryParams: {
                "departid": departid,
                "dormname": dormname
            },
            url: "<?php echo U('BaseData/getDormByPage','','');?>",
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
                    {field: 'id', align: "center", title: "编号", width: 100},
                    {field: 'dormvalue', align: "center", title: "寝室名称", width: 100},
                    {field: 'dclass', align: "center", title: "寝室类别", width: 100},
                    {field: 'spec', align: "center", title: "寝室规格", width: 100},
                    {field: 'xbmc', align: "center", title: "所属院系", width: 100},
                    {field: 'opt', align: "center", title: "操作", width: 80, formatter: showDormOptBtn}
                ]]
        });
    }


    function showDormOptBtn(value, row, index) {
        return "<a href='#' onclick='editDorm(" + index + ")' class='easyui-linkbutton' id='editDorm' name='editDorm'>编辑</a>";
    }



    function editDorm(rowIndex) {
        //获取当前选中行的索引
        selectedRowIndex = $('#Dorm-datagrid').datagrid('getRowIndex', $('#Dorm-datagrid').datagrid('getSelected'));
        //判断当前按钮所在行与当前选中行是否一致
        if (rowIndex == selectedRowIndex) {
            row = $('#Dorm-datagrid').datagrid('getSelected');
            if (row) {
                xbmc = row['xbmc'];
                dormvalue = row['dormvalue'];
                dclass = row['dclass'];
                spec = row['spec'];
                xbid = row['id'];
                $('#edit_d_department').combobox('setValue', row['xbmc']);
                $('#add_dormname').textbox('setValue', row['dormvalue']);
                $('#edit_d_sex').combobox('setValue', row['dclass']);
                $('#edit_d_spec').combobox('setValue', row['spec']);
                $('#dorm-dialog').dialog({
                    closed: false,
                    modal: true,
                    title: "编辑寝室",
                    top: 30,
                    buttons: [{
                            text: '确定',
                            iconCls: 'icon-ok',
                            handler: doSaveDorm
                        }, {
                            text: '取消',
                            iconCls: 'icon-cancel',
                            handler: function () {
                                $('#dorm-dialog').dialog('close');
                            }
                        }]
                });
            }
        }
    }
    function doSaveDorm() {
        vikxbmc = $('#edit_d_department').combobox('getValue');
        for (i = 0; i < combx.length; i++) {
            if (vikxbmc == combx[i].text) {
                vikxbmc = i;
            }
        }
        vikdormvalue = $('#add_dormname').textbox('getValue');
        vikdclass = $('#edit_d_sex').combobox('getText');
        vikspec = $('#edit_d_spec').combobox('getValue');
        if (vikxbmc != -1 && vikdclass != -1 && vikspec != -1 && vikdormvalue != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveDorm','','');?>",
                data: {"vikxbmc": vikxbmc, "vikdormvalue": vikdormvalue, "vikdclass": vikdclass, "vikspec": vikspec, "datatype": 111, 'xbid': xbid},
                type: "post",
                dataType: "json",
                success: function (data) {
                    if (data > 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '修改成功'
                        });
                        $('#dorm-dialog').dialog('close');
                        $('#Dorm-datagrid').datagrid('reload');
                    } else {
                        $.messager.show({
                            title: '系统提示',
                            msg: '修改数据与原数据一致'
                        });
                    }
                },
            });
        } else {
            $.messager.show({
                title: '系统提示',
                msg: '填写名称不能为空'
            });
        }
    }

    function openAddDorm() {
        $('#dorm-dialog').dialog({
            closed: false,
            modal: true,
            title: "添加寝室",
            top: 30,
            buttons: [{
                    text: '确定',
                    iconCls: 'icon-ok',
                    handler: adDdorm
                }, {
                    text: '取消',
                    iconCls: 'icon-cancel',
                    handler: function () {
                        $('#dorm-dialog').dialog('close');
                    }
                }]
        });
    }
    function adDdorm() {
        dormvalue = $('#add_dormname').textbox('getValue');
        dclass = $('#edit_d_sex').combobox('getText');
        spec = $('#edit_d_spec').combobox('getValue');
        xbdm = $('#edit_d_department').combobox('getValue');
        if (xbdm != -1 && dclass != -1 && spec != -1 && dormvalue != '') {
            $.ajax({
                url: "<?php echo U('BaseData/doSaveDorm','','');?>",
                data: {"xbdm": xbdm, "dormvalue": dormvalue, "dclass": dclass, "spec": spec, "datatype": 110},
                type: "post",
                dataType: "json",
                success: function (data) {
                    if (data > 0) {
                        $.messager.show({
                            title: '系统提示',
                            msg: '添加成功'
                        });
                        $('#dorm-dialog').dialog('close');
                        $('#Dorm-datagrid').datagrid('reload');
                    }
                },
            });
        } else {
            $.messager.show({
                title: '系统提示',
                msg: '填写的数据不能有空项'
            });
        }
    }
    $(function () {
        combx = [{'text': '请选择', 'value': '-1'}];
        comb = [{'text': '请选择', 'value': '-1'}];
        Loaddep("#q_department",combx);
        Loaddep("#edit_d_department",comb);
    });
    function Loaddep(a,com) {
        $.ajax({
            url: "<?php echo U('Registration/select','','');?>",
            data: {"data": 1},
            method: "post",
            dataType: "json",
            success: function (data) {
                for (i = 0; i < data.length; i++) {
                    com.push({"text": data[i].xbmc, "value": data[i].xbdm});
                }
                $(a).combobox("loadData", com);
            }
        });
    }
</script>