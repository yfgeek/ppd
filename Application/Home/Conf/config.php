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
        '__STATIC__' => __ROOT__ . '/Public/Static',
        '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),
);