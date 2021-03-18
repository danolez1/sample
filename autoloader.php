<?php
/*error_reporting(E_ALL);
 file_uploads = On
 post_max_size = 100M
 upload_max_filesize = 100M
 setcookie('lingo', $_COOKIE['lingo'], time() + time(), "/");*/

/**Comment Start */
// date_default_timezone_set("Asia/Tokyo");
// set_time_limit(0);
// try {
//     if (!isset($_COOKIE['lingo']) || is_null($_COOKIE['lingo']) || $_COOKIE['lingo'] == "") {
//         $_COOKIE['lingo'] =  explode('/', date_default_timezone_get())[0] == "Asia" ? 'jp' : 'en';
//         setcookie('lingo', $_COOKIE['lingo'], time() + time(), "/");
//     }
// } catch (Exception $e) {
//     /* var_dump( $e)*/
// }
/**Comment Stop */


function errorHandler($errno, $errstr, $errfile, $errline, array $errcontext)
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function shutdownHandler()
{
    $lasterror = error_get_last();
    if (!is_null($lasterror) && !empty($lasterror)) {
        switch ($lasterror['type']) {
            default:
                if ($lasterror['type']) {
                    throw new ErrorException($lasterror['message'], 0, $lasterror['type'], $lasterror['file'], $lasterror['line']);
                }
        }
    }
}
set_error_handler('errorHandler', E_ALL);
register_shutdown_function('shutDownHandler');

define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);
define("APP", ROOT . 'app' . DIRECTORY_SEPARATOR);
define("PHP_LIB", APP . 'lib' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);
define("DB_CORE", PHP_LIB . 'DB' . DIRECTORY_SEPARATOR);
define("RESOURCES", PHP_LIB . 'Res' . DIRECTORY_SEPARATOR);
define("SECURITY", PHP_LIB . 'Security' . DIRECTORY_SEPARATOR);
define("MODELS", APP . 'Models' . DIRECTORY_SEPARATOR);
define("CHANNEL", APP . 'Channels' . DIRECTORY_SEPARATOR);
define("CONTROLLER", APP . 'Controllers' . DIRECTORY_SEPARATOR);
define("ROUTE", ROOT . 'Routes' . DIRECTORY_SEPARATOR);
define('PRINT_NODE', RESOURCES . 'PrintNode' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'PrintNode' . DIRECTORY_SEPARATOR);


/**Comment Start */
// error_reporting(0);
// ini_set('display_errors', '0');
// ini_set('display_startup_errors', '0');
// ini_set("session.use_strict_mode", true);
// ini_set("session.use_cookies", 1);
// ini_set("session.use_trans_sid", 1);
// ini_set('log_errors', 1);
// ini_set('error_reporting', 32767);
// ini_set('error_log', ROOT . 'error_log.txt');
/**Comment Stop */

$modules = [ROOT, APP, PHP_LIB, DB_CORE, RESOURCES, SECURITY, MODELS, CHANNEL, CONTROLLER, ROUTE];
/* scan through each folder to self include*/
// try {
foreach ($modules as $module) :
    $fileList = glob($module . '*.php');
    foreach ($fileList as $filename)
        require_once $filename;

endforeach;
// } catch (Exception $e) {
 /* s var_dump($e);*/
// }
