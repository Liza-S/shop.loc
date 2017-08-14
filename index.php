<?
//ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL & ~E_NOTICE);
//error_reporting(E_ALL);
ob_start();

define('PATH_TO_SAVE', __DIR__ . DIRECTORY_SEPARATOR .'images');
define('PATH_TO_DELETE', __DIR__);

include 'lib.php';

route();

ob_end_flush();