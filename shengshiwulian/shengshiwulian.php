<?php

/**
 * 盛世物联 PHP Framework
 * @author fan
 * @link http://www.shengshiwulian.com
 */
header('Content-type: text/html; charset=utf-8');
define('APP_BASE_PATH', realpath('./'));
define('EXT', '.php');
define('DEBUG', true);

date_default_timezone_set('PRC');

//设置错误句柄
set_error_handler("\shengshiwulian\Error::message");

//判断php版本
$php_version = explode('-', phpversion());
if (strnatcasecmp($php_version[0], '5.3.0') < 0) {
    \shengshiwulian\Error::show('PHP版本过低', __FILE__);
}

require_once 'function' . EXT;

\shengshiwulian\Application::start()->run();
