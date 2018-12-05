<?php if (!defined('THINK_PATH')) exit();?><div style="width:1000px;height:100%;padding:10px;margin:20px auto;">
    <div class="easyui-panel" style="height:400px;" title="按院系统计数据报表">
        <div id="departmet_report" style="height:350px;width:950px;margin-top:10px;">

        </div>
    </div>
</div>
<div style="width:1000px;height:100%;padding:10px;margin:5px auto;">
    <div class="easyui-panel" style="height:400px;" title="按专业统计数据报表">
        <div id="major_report" style="height:350px;width:950px;margin-top:10px;">

        </div>
    </div>
</div>
<script src="<?php echo JS ?>/echarts.min.js" type="text/javascript">
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


<script>
    $(function () {
        $.ajax({
            url: "<?php echo U('Registration/yxcount','','');?>",
            datatype: 'json',
            type: 'post',
            success: function (data) {
                if (data.length > 0) {
                    Drawyx(data);
                }
            }
        });
        $.ajax({
            url: "<?php echo U('Registration/zycount','','');?>",
            datatype: 'json',
            type: 'post',
            success: function (data) {
                if (data.length > 0) {
                    Drawzy(data);
                }
            }
        });
    });
    function Drawzy(date) {
        var major = echarts.init(document.getElementById('major_report'));
        majors = [];
        counts = [];
        for (i = 0; i < date.length; i++) {
            majors.push(date[i].zycount);
            counts.push(date[i].major);
        }
        option = {
            title: {
                text: '按专业统计数据报表',
                x: 'center',
                subtext: '报到人数情况'
            },
            tooltip: {},
            xAxis: {
                data: counts
            },
            yAxis: {},
            series: [{
                    type: 'bar',
                    data: majors
                }]
        };
        major.setOption(option);
    }
    function Drawyx(date) {
        departmet = echarts.init(document.getElementById('departmet_report'));
        ydata = [];
        legende = [];
        for (i = 0; i < date.length; i++) {
            legende.push(date[i].name);
            ydata.push(date[i].value);
        }
        option = {
            title: {
                text: '按院系统计数据报表',
                x: 'center',
                subtext: '报到人数情况'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: legende
            },
            series: [
                {
                    name: '',
                    type: 'pie',
                    radius: '80%',
                    center: ['50%', '55%'],
                    data: date,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        departmet.setOption(option);
    }
</script>