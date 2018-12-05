<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <meta content="" name="copyright"/>
        <title>
            新生报到管理系统
        </title>
        <script type="text/javascript">
            function showTime() {
                nowtime = new Date();
                year = nowtime.getFullYear();
                month = nowtime.getMonth() + 1;
                date = nowtime.getDate();
                document.getElementById("nowTime").innerText = year + "年" + month + "月" + date + "日 " + nowtime.toLocaleTimeString();
            }
            setInterval("showTime()", 1000);
            function addTab(title, url, seticon) {
                if ($('#tt').tabs('exists', title)) {
                    $('#tt').tabs('select', title);
                } else {
                    var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>';
                    $('#tt').tabs('add', {
                        title: title,
                        content: content,
                        closable: true,
                        iconCls: seticon
                    });
                }
            }
            function closeAll() {
                $.messager.confirm('清除缓存', '确认是否关闭所有选项卡清除缓存?', function (r) {
                    $(".tabs li").each(function (index, obj) {
                        //获取所有可关闭的选项卡
                        var tab = $(".tabs-closable", this).text();
                        $(".easyui-tabs").tabs('close', tab);
                    });
                    $("#close").remove();//同时把此按钮关闭
                });
            }
        </script>
    </head> 
    <body class="easyui-layout" onload="">
        <!-- begin of header -->
        <div class="wu-header" data-options="region:'north',border:false,split:true">
            <div class="wu-header-left">
                <h1>
                    新生报到管理系统       
                </h1>
               
            </div>
            <div class="wu-header-right">
                <p>
                    欢迎您 <a href="" style="color: red"><?php echo (session('user_name')); ?></a>
                    <a href="#"class='tabs-inner' onclick="closeAll()">
                        清除缓存
                    </a>
                    |
                    <a href="/Nsrms/Home/Login/exits">
                        安全退出
                    </a>
                </p>
                <p>
                    <a id="nowTime">

                    </a>
                </p>
            </div>
        </div>
        <!-- end of header -->
        <!-- begin of sidebar -->
        <div class="easyui-layout" style="width:150px;height:350px;" data-options="region:'west',split:true,border:true,title:'导航菜单'">
            <div class="easyui-accordion" data-options="border:false,fit:true,selected:false">
                <?php if(is_array($mangername)): $i = 0; $__LIST__ = $mangername;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-options="region:'north',split:true" title="<?php echo ($vo["auth_name"]); ?>" >
                        <ul class="easyui-tree"id="basetree" >
                            <?php if(is_array($subseries)): $i = 0; $__LIST__ = $subseries;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vod): $mod = ($i % 2 );++$i; if($vo["id"] == $vod["auth_type"] ): ?><li data-options="iconCls:'<?php echo ($vod["iconcls"]); ?>'"><a onclick="addTab('<?php echo ($vod["auth_name"]); ?>', '/Nsrms/Home/<?php echo ($vod["controller_cn"]); ?>/<?php echo ($vod["method"]); ?>', '<?php echo ($vod["iconcls"]); ?>')"><?php echo ($vod["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <!-- end of sidebar -->
        <!-- begin of main -->
        <div class="wu-main" data-options="region:'center'">
            <div class="easyui-tabs" data-options="border:false,fit:true" id="tt">
                <div data-options="href:'<?php echo U('index.php/Home/Index/info');?>',closable:false,iconCls:'icon-tip',cls:'pd3'" title="欢迎使用">
                </div>
            </div>
        </div>
        <!-- end of main -->
        <!-- begin of footer -->
      
        
        <div class="wu-footer" data-options="region:'south',border:true,split:true">
            © 2018 Copy Rights Reserved
        </div>
        <!-- end of footer -->
    </body>
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



</html>