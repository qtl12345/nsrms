<?php if (!defined('THINK_PATH')) exit();?><link href="<?php echo EASYUI ?>/themes/default/easyui.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS ?>/wu.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo CSS ?>/icon.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo JS ?>/jquery.mloading.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo JS ?>/jquery-3.2.0.min.js" type="text/javascript">
</script>
<script src="/Nsrms/Public/uploaddify/jquery.uploadify.min.js" type="text/javascript" >
</script>
<script src="<?php echo EASYUI ?>/jquery.easyui.min.js" type="text/javascript">
</script>
<script src="<?php echo EASYUI ?>/locale/easyui-lang-zh_CN.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/jquery.form.min.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/jquery.seat-charts.min.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/abc.js" type="text/javascript">
</script>
<script src="<?php echo JS ?>/jquery.mloading.js" type="text/javascript">
</script>
<link href="/Nsrms/Public/uploaddify/uploadify.css" rel="stylesheet" type="text/css"/>
<div id="aa" style="width:1000px;height:80%;margin:5px auto;">
    <div class="easyui-panel" style="height:550px;" title="">
        <table align="center" bgcolor="#D6D6D6" border="0" cellpadding="0" cellspacing="0" width="98%">
            <tr>
                <td align="center" bgcolor="#FFFFFF" valign="top">
                    <form id="registrationForm" name="registrationForm">
                        <!--<input type="hidden" id="studentId" name="studentId"/>-->
                        <table border="0" cellpadding="4" cellspacing="1" class="student" width="80%">
                            <tr bgcolor="#F9FAF3">
                                <td align="right" width="15%">
                                    通知书编号：
                                </td>
                                <td width="30%">
                                    <input class="easyui-textbox" maxlength="18" id="noticeNumber" name="noticeNumber"
                                           style="width:180px;" type="text" data-options="prompt:'输入通知书号回车查询'"/>
                                    <font color="red">*</font>
                                    <button type="button"class="easyui-linkbutton" data-options="iconCls:'icon-search'"
                                            onclick="savenumber()" id="QueryBtn">查询</button>
                                </td>
                                <td align="right" width="15%">
                                    考生号：
                                </td>
                                <td width="25%">
                                    <!--data-options="required:true"-->
                                    <input class="easyui-textbox" name="examineeNumber"id="examineeNumber" type="text"/>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    姓名：
                                </td>
                                <td>
                                    <input class="easyui-textbox" name="studentName"  id="studentName" type="text"/>
                                    <font color="red">*</font>
                                </td>
                                <td align="right" rowspan="5">
                                    照片：<font color="red">*</font>
                                </td>
                                <td rowspan="5">
                                    <img id="upload_face" src="/Nsrms/Public/images/noface.gif"
                                         style="width:108px;height:128px;"/>
                                    <input type = "file"  id="file_upload" name = "file_upload"/> 
                                    <input type="hidden" id="photoc" name="photoc"/>
                                </td>
                            </tr>
                            <tr bgcolor="#F9FAF3">
                                <td align="right">
                                    性别：
                                </td>
                                <td>
                                    <select class="easyui-combobox"style="width:160px;" editable="false" id="sex" name="sex" panelheight="auto"
                                            >
                                        <option value="-1">请选择</option>
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    身份证号：
                                </td>
                                <td>
                                    <input class="easyui-textbox" data-options="" id="idcard"
                                           name="idcard"  style="width:160px;" type="text"/>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr bgcolor="#F9FAF3">
                                <td align="right">
                                    出生日期：
                                </td>
                                <td width="25%">
                                    <input editable="false"class="easyui-textbox"id="birthday" name="birthday" style="width:160px;"
                                           />
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    民族：
                                </td>
                                <td>
                                    <select class="easyui-combobox" editable="false" id="nation" name="nation"
                                            style="width:160px;">
                                    </select>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr bgcolor="#F9FAF3">
                                <td align="right">
                                    院系：
                                </td>
                                <td width="25%">
                                    <select panelheight="auto"  class="easyui-combobox" editable="false" id="department" name="department" style="width:160px;" >
                                        <option value="-1">请选择</option>
                                    </select>
                                    <font color="red">*</font>
                                </td>
                                <td align="right">
                                    专业：
                                </td>
                                <td>
                                    <select panelheight="auto"class="easyui-combobox" editable="false" id="major" name="major"style="width:160px;"
                                            >
                                        <option value="-1">请选择</option>
                                    </select>
                                    <font color="red">*</font>
                                </td>   
                            </tr>
                            <tr>
                                <td align="right">
                                    邮政编码：
                                </td>
                                <td width="25%">
                                    <input class="easyui-textbox"  name="postcode" id="postcode" type="text"/>
                                    <font color="red">*</font>
                                </td>
                                <td align="right">
                                    毕业中学：
                                </td>
                                <td>
                                    <input class="easyui-textbox"  name="finishSchool" id="finishSchool" type="text"/>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr bgcolor="#F9FAF3">
                                <td align="right">
                                    本人联系电话：
                                </td>
                                <td width="25%">
                                    <input class="easyui-textbox"  name="telphone" id="telphone" type="text"/>
                                    <font color="red">*</font>
                                </td>
                                <td align="right">
                                    家长联系电话：
                                </td>
                                <td>
                                    <input class="easyui-textbox"  name="parentTel" id="parentTel" type="text"/>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    家庭住址：
                                </td>
                                <td colspan="3">
                                    <input class="easyui-textbox"  name="homeAddress" id="homeAddress" style="width:600px;"
                                           type="text"/>
                                    <font color="red">*</font>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="4">
                                    <a class="easyui-linkbutton " 
                                       onclick="validateForm()" id="saveBtn" data-options="iconCls:'icon-reload'">保存</a>
                                    <a class="easyui-linkbutton" data-options="iconCls:'icon-reload'"
                                       onclick="resetForm()" id="resetBtn">重置</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>
<script type="text/javascript">
    var m = '';
    var im = "/Nsrms/Public/images/noface.gif";
    //加载日期插件
    $('#birthday').datebox({
    });
    //ajax提交表单
    function savedata() {
        $.ajax({
            url: "<?php echo U('Registration/savedata','','');?>",
            data: $('#registrationForm').serialize(),
            type: "post",
            dataType: "json",
            success: function (dataaa) {
                $.messager.show({
                    title: '系统提示',
                    msg: dataaa
                });
                resetForm();
            }
        });
    }
    //加载民族
    $('#nation').combobox({
        url: '/Nsrms/Public/json/nation.json',
        valueField: 'name',
        textField: 'name'
    });
    //加载院系及专业
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
                    yxvalue = $('#department').combobox('getValue');
                    if (yxvalue != -1) {
                        $.ajax({
                            url: "<?php echo U('Registration/select','','');?>",
                            data: {"data": "2", "datatype": yxvalue},
                            method: "POST",
                            dataType: "json",
                            async: false,
                            success: function (data) {
                                themecombo2 = [{'zymc': '请选择', 'zydm': '-1'}];
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
                        $('#major').combobox('setValue', '-1'); //一定要先value后text,否则text与value值会相同全为value值  
                        $('#major').combobox('setText', '请选择');
                    }
                }
            });
        }
    });
    //查询后给文本框赋值
    function savenumber() {
        var noticeNumber = $("#noticeNumber").val();
        $.ajax({
            url: "<?php echo U('Registration/select','','');?>",
            data: {"noticeNumber": noticeNumber, "data": "3"},
            type: "post",
            dataType: "json",
            beforeSend: function () {
                $("body").mLoading("show");
            },
            success: function (data) {
                if (data[0] == '没有找到该通知书编号!') {
                    $.messager.show({
                        title: '系统提示',
                        msg: data
                    });
                }else{
                path = data['sum'].photo;
                if (path == '') {
                    path = "Public/images/noface.gif";
                }
                $('#registrationForm').form('load', {
                    examineeNumber: data['sum'].candidatenumber,
                    studentName: data['sum'].name,
                    upload_face: $("#upload_face").attr("src", "/Nsrms/" + path),
                    sex: data['sum'].sex,
                    idcard: data['sum'].idnumber,
                    birthday: data['sum'].birthdata,
                    nation: data['sum'].nation,
                    department: data['xbdm'],
                    major: data['zydm'],
                    postcode: data['sum'].postcode,
                    finishSchool: data['sum'].graduatedschool,
                    telphone: data['sum'].myphone,
                    parentTel: data['sum'].patriarchphone,
                    homeAddress: data['sum'].address,
                    photoc: data['sum'].photo
                });
            }
            },
            complete: function () {
                $("body").mLoading("hide");
            }
        });
    }
    //加载uploadify图片插件
    $(document).ready(function () {
        $('#file_upload').uploadify({
            'swf': '/Nsrms/Public/uploaddify/uploadify.swf',
            'uploader': '/Nsrms/Home/Registration/uploadify',
            'buttonText': '选择照片',
            'width': '100', //按钮宽度
            'height': '30', //按钮高度
            'fileTypeDesc': "请选择图片文件",
            'displayData': 'speed',
            'rollover': true,
            'cancelImg': '/Nsrms/Public/uploaddify/uploadify-cancel.png',
            'fileObjName': "img_path",
            'multi': false,
            'onUploadSuccess': function (file, data, response) {
                $('#photoc').val(data);
                $("#upload_face").attr("src", "/Nsrms/" + data);
            }
        });
    });
    function validateForm() {
        if ($.trim($('input[textboxname=noticeNumber]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "通知书编号没有填写"
            });
            $('input[textboxname=noticeNumber]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=examineeNumber]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "考生号没有填写"
            });
            $('input[textboxname=examineeNumber]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=studentName]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "新生名字没有填写"
            });
            $('input[textboxname=studentName]').textbox().next('span').find('input').focus();
            return;
        }
        if ($("#sex").combobox('getValue') == -1) {
            $.messager.show({
                title: '系统提示',
                msg: "请选择性别"
            });
            return;
        }
        if ($.trim($('input[textboxname=idcard]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "身份证号没有填写"
            });
            $('input[textboxname=idcard]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=birthday]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "出生日期没有填写"
            });
            $('input[textboxname=idcard]').textbox().next('span').find('input').focus();
            return;
        }
        if ($("#nation").combobox('getValue') == '请选择') {
            $.messager.show({
                title: '系统提示',
                msg: "请选择民族"
            });
            return;
        }
        if ($("#department").combobox('getValue') == '请选择') {
            $.messager.show({
                title: '系统提示',
                msg: "请选择院系"
            });
            return;
        }
        if ($("#major").combobox('getValue') == "请选择" || $("#major").combobox('getValue') == -1) {
            $.messager.show({
                title: '系统提示',
                msg: "请选择专业"
            });
            return;
        }
        if ($.trim($('input[textboxname=postcode]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "邮政编码没有填写"
            });
            $('input[textboxname=postcode]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=finishSchool]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "毕业中学没有填写"
            });
            $('input[textboxname=finishSchool]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=telphone]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "本人电话没有填写"
            });
            $('input[textboxname=telphone]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=parentTel]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "家长电话没有填写"
            });
            $('input[textboxname=parentTel]').textbox().next('span').find('input').focus();
            return;
        }
        if ($.trim($('input[textboxname=homeAddress]').textbox('getValue')) == "") {
            $.messager.show({
                title: '系统提示',
                msg: "家庭地址没有填写"
            });
            $('input[textboxname=homeAddress]').textbox().next('span').find('input').focus();
            return;
        }
        if ($("#upload_face").attr("src") == im) {
            $.messager.show({
                title: '系统提示',
                msg: "请上传新生照片"
            });
            return;
        }
        savedata();
    }
    //清空表单
    function resetForm() {
        $('input[textboxname=studentName]').textbox('setValue', '');
        $('input[textboxname=noticeNumber]').textbox('setValue', '');
        $('input[textboxname=examineeNumber]').textbox('setValue', '');
        $('input[textboxname=idcard]').textbox('setValue', '');
        $('input[textboxname=birthday]').textbox('setValue', '');
        $('input[textboxname=postcode]').textbox('setValue', '');
        $('input[textboxname=finishSchool]').textbox('setValue', '');
        $('input[textboxname=telphone]').textbox('setValue', '');
        $('input[textboxname=parentTel]').textbox('setValue', '');
        $('input[textboxname=homeAddress]').textbox('setValue', '');
        $("#sex").combobox('setValue', -1);
        $("#sex").combobox('setText', '请选择');
        $("#nation").combobox('setValue', -1);
        $("#nation").combobox('setText', '请选择');
        $("#department").combobox('setValue', -1);
        $("#department").combobox('setText', '请选择');
        $("#major").combobox('setValue', -1);
        $("#major").combobox('setText', '请选择');
        $('#studentFace').val('');
        $('#face').val('');
        $('#studentId').val('');
        $('#upload_face').attr('src', '/Nsrms/Public/images/noface.gif');
        $('input[textboxname=noticeNumber]').textbox().next('span').find('input').focus();
    }
</script>
﻿