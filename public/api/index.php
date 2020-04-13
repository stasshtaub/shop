<?
define('ROOT_DIR', __DIR__);
header("Content-Type: application/json;charset=utf-8");
require_once ROOT_DIR . "/Core/Router.php";
Router::start();
