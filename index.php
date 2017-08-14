<?
//ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_WARNING);
//error_reporting(E_ALL);
ob_start();

define('PATH_TO_SAVE', __DIR__ . DIRECTORY_SEPARATOR .'images');

include 'lib.php';

route();

ob_end_flush();