<?php

return array(
    //'配置项'=>'配置值'
    'URL_MODEL' => 2,
    'debug' => true,
    'URL_HTML_SUFFIX' => 'html',
    'MODULE_ALLOW_LIST' => array('Home'),
    'DEFAULT_MODULE' => 'Home', // 默认模块 
    'DEFAULT_CONTROLLER' => 'Login', // 默认控制器名称
    'DEFAULT_ACTION' => 'login', // 默认操作名称
    'AUTOLOAD_NAMESPACE' => array(
        'PhpOffice' => THINK_PATH . 'Library/Vendor/PhpOffice/PhpSpreadsheet',
    ),
);
