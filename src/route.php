<?php
require_once("autoload.php");

$request = $_SERVER['REQUEST_URI'];
$part = explode("/", $request);
$func = isset($part[1])? $part[1]: "";
$step = isset($part[2])? $part[2]: "";
$db   = isset($part[3])? $part[3]: "";

switch ($request) {
    case '/' :
        require __DIR__ . '/index.php';
        break;
    case '' :
        require __DIR__ . '/index.php';
        break;
    case '/about' :
        require __DIR__ . '/about.php';
        break;
    default:
        // echo "request: $request<br/>";
        // echo "func: $func<br/>";
        // echo "step: $step<br/>";
        // echo "db: $db<br/>";
        require __DIR__ . "/index.php";

        break;
}
?>
