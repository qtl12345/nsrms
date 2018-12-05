<?php if (!defined('THINK_PATH')) exit();?><style>
    .linkButton{
        display: inline-block;
        vertical-align: middle;
        padding: 12px 24px;
        margin: 55px 200px auto;
        font-size: 18px;
        line-height: 24px;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        color: white;
        background-color: #55B55B;
        border-radius: 3px;
        border: none;
        -webkit-appearance: none;
        outline:none;
        width:30%;
    }
    .forbidden {
        pointer-events: none;
        filter: alpha(opacity=50); /*IE滤镜，透明度50%*/
        -moz-opacity: 0.5; /*Firefox私有，透明度50%*/
        opacity: 0.5; /*其他，透明度50%*/
    }
</style>
<link href="/Nsrms/Public/js/loading/jquery.mloading.css" rel="stylesheet" type="text/css"/>
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


<script src="/Nsrms/Public/js/loading/jquery.mloading.js" type="text/javascript">
</script>
<div style="width:650px;height:70%;padding:10px;margin:20px auto;">
    <div class="easyui-panel" style="height:400px;" title="">
        <a class="linkButton" href="/Nsrms/Public/template/template.xlsx" style="color:white;" onmouseover="this.style.cssText = 'color:white;'">
            下载模板
        </a>
        <form id="importForm" action="" enctype="multipart/form-data" method="post">
            <input id="xlsxfile" name="xlsxfile" onchange="checkfileChange()" type="file" accept="application/vnd.ms-excel" style="display:none"/>
            <a class="linkButton" href="#" id="chooseFile" onmouseover="this.style.cssText = 'color:white;'">
                选择文件
            </a>
            <a class="linkButton" id="doimport" href="#" onclick="checkFile()" onmouseover="this.style.cssText = 'color:white;'">
                开始导入
            </a>
        </form>
    </div>
</div>
<script>
    $(function () {
        $("#chooseFile").click(function () {
            $("#xlsxfile").trigger("click");
        });
        $('#doimport').addClass('forbidden');
    });
    function checkfileChange() {
        if ($('#xlsxfile').val() == null || $('#xlsxfile').val() == '') {
            $('#doimport').addClass('forbidden');
        } else {
            $('#doimport').removeClass('forbidden');
        }
    }
    function checkFile() {
        if ($('#xlsxfile').val() == null || $('#xlsxfile').val() == '') {
            $.messager.show({
                title: '系统提示',
                msg: '请先选择要导入的数据文件'
            });
            return;
        }
        importFile();
    }
    function resetFileInput(file) {
        file.after(file.clone().val(""));
        file.remove();
    }
    function importFile() {
        $("#importForm").ajaxSubmit({
            url: "<?php echo U('User/loaddata','','');?>",
            type: "post",
            dataType: "json",
            beforeSubmit: function (arr, $form, options) {
                $('body').mLoading("show");//显示loading组件
            },
            //提交成功后的回调函数
            success: function (result, status, xhr, $form) {
                $('body').mLoading("hide");//隐藏loading组件
                $.messager.show({
                    title: '系统提示',
                    msg: result.msg
                });
                resetFileInput($("#xlsxfile"));
                $('#doimport').addClass('forbidden');
            },
            error: function (xhr, status, error, $form) {},
            complete: function (xhr, status, $form) {}
        });
    }
</script>