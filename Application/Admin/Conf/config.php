<?php
return array(
    'URL_MODEL'=>2,
	//'配置项'=>'配置值'
	'URL_HTML_SUFFIX' => '',
	/* 数据缓存设置 */
    'DATA_CACHE_PREFIX'    => 'onethink_', // 缓存前缀
    'DATA_CACHE_TYPE'      => 'File', // 数据缓存类型
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/'
    ),

    /* 版本 */
    'VERSION' => '3.2.1',
	/* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'blog', //session前缀
    'COOKIE_PREFIX'  => 'blog_', // Cookie前缀 避免冲突
    'VAR_SESSION_ID' => 'session_id',	//修复uploadify插件无法传递session_id的bug
    'URL_MODEL' => '2',
    'SHOW_PAGE_TRACE'        =>false,
    /* 拍拍贷 API ID */
    'APPID' =>  "5223d676d9dd48f5bf486b73d60e206c",
    /* 拍拍贷 API 私钥 */
    'APPPV' => "MIICXQIBAAKBgQC7luOu0RN4aC1uHxZUb7IYDe4yJAWoiR231vPbsWRoV0s3YYSxu9iluQv6DDoNK/Ja+KAZ2ooORk/W/3GIB9Zv9heJZ6Jt50/DCghkTAAIa3rGsD9SretvHu67vSl3usxbg7frafLrMbAQjch8QyYvbx9kashvKZWnGgwWffR24wIDAQABAoGAOHLCVtOxYTUwHogaRxRJajWe7NWsIjgIik6TmRN7XG6QQr0EmhslqVDSys6tFVOZHUjdnIoHqx37Xn4FouKA4zIJSs+P8sP/3HW/YkWtrthn4FauI0CupgsyCkJCKb+AMkFGAV43WH7nTjRo3P5up23hVyTCpJQ7k0DW2isUY6ECQQDlp8kpFiueG0v9HTq8quLqs/OlC1fEylMI7dTsxG1BZ9q+4Y4VberMhaHRlg8S/gA8AhbNjrwPVplsWpPTSJHRAkEA0RvD63wrzas1xg6PvwaUAoa20M7VFguQjeVPl+85eFeDGXHX/E3FUKUuKG6xRSOT8F5j2XXcz/duM1G/tGMWcwJBALJx5CmLs4qftTTQwHIW6kjqWLf2j1U2zLxUaK0sl6RJuTu2cTuPc/FFKI585eug97eo++TvMotMg9wgqVpzufECQQC7sUldMJp8xCXDPcTG+ReXYOXtbQmU/RJmWyLjRGX4X8yb5TSyEfh/F5Tj09+oKHQcuAy133Yw8W3oAIOrXZmDAkBv+ObNKExZ1ZKDYvUnPG1cKfEzIjD37twOzTOaxLOHMRcjmE0eYR9rx3hKrBqFzEptgvFFFyRtLJlGaKnYSy58",
    /* 拍拍贷 API 公钥 */
    'APPPUB' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC7luOu0RN4aC1uHxZUb7IYDe4yJAWoiR231vPbsWRoV0s3YYSxu9iluQv6DDoNK/Ja+KAZ2ooORk/W/3GIB9Zv9heJZ6Jt50/DCghkTAAIa3rGsD9SretvHu67vSl3usxbg7frafLrMbAQjch8QyYvbx9kashvKZWnGgwWffR24wIDAQAB"
    // 'APPPVK' => "",
    // "APPPBK" => ""

    ///* 后台错误页面模板 */
    //'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
    //'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
    //'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Public/exception.html',// 异常页面的模板文件
);
