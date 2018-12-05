<?php if (!defined('THINK_PATH')) exit();?>﻿<style>
    .info{
        margin: 15px auto;
    }
    .info tr{
        line-height: 35px;
    }
    .info tr td:nth-child(2){
        text-align:left;
        width:70%;
    }
</style>
<div style="width:850px;height:70%;padding:10px;margin:20px auto;">
    <div class="easyui-panel" style="height:340px;" title="服务器环境信息">
        <table class="info">
            <tr>
                <td width="20%">
                    操作系统:
                </td>
                <td>
                    <?php echo (PHP_OS); ?>
                </td>
            </tr>
            <tr>
                <td>
                    WEB服务器
                </td>
                <td>
                    <?php echo ($_SERVER['SERVER_SOFTWARE']); ?>
                </td>
            </tr>
            <tr>
                <td>
                    MySQL版本
                </td>
                <td>
                    <?php echo (PHP_VERSION); ?>
                </td>
            </tr>
            <tr>
                <td>
                    PHP版本
                </td>
                <td>
                    <?php echo (MYSQL_VERSION); ?>
                </td>
            </tr>
            <tr>
                <td>
                    服务器IP
                </td>
                <td>
                    <?php echo $_SERVER["SERVER_NAME"] ?>
                </td>
            </tr>
            <tr>
                <td>
                    服务器端口
                </td>
                <td>
                    <?php echo $_SERVER['SERVER_PORT']?>
                </td>
            </tr>
            <tr>
                <td>
                    站点物理路径
                </td>
                <td>
                    <?php echo WWWROOT?>
                </td>
            </tr>
             <tr>
                <td>
                    当前登录时间
                </td>
                <td>
                    <?php echo (session('now')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>