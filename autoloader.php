<?php
//error_reporting(0); //DISPLAY NO ERROR
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// file_uploads = On
// post_max_size = 100M
// upload_max_filesize = 100M
define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR . 'demae-sample' . DIRECTORY_SEPARATOR);
define("APP", ROOT . 'app' . DIRECTORY_SEPARATOR);
define("PHP_LIB", APP . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);
define("DB_CORE", PHP_LIB . 'DB' . DIRECTORY_SEPARATOR);
define("RESOURCES", PHP_LIB . 'Res' . DIRECTORY_SEPARATOR);
define("SECURITY", PHP_LIB . 'Security' . DIRECTORY_SEPARATOR);
define("MODELS", APP . 'Models' . DIRECTORY_SEPARATOR);
define("CHANNEL", APP . 'Channels' . DIRECTORY_SEPARATOR);
define("CONTROLLER", APP . 'Controllers' . DIRECTORY_SEPARATOR);
define("ROUTE", ROOT . 'Routes' . DIRECTORY_SEPARATOR);

$modules = [ROOT, APP, PHP_LIB, DB_CORE, RESOURCES, SECURITY, MODELS, CHANNEL, CONTROLLER, ROUTE];
// scan through each folder to self include
foreach ($modules as $module) :
    $fileList = glob($module . '*.php');
    foreach ($fileList as $filename)
        require_once $filename;

endforeach;
