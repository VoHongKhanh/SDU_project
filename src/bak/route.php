<?php
require_once("autoload.php");

$request = $_SERVER['REQUEST_URI'];
$part = explode("/", $request);
$func = isset($part[1])? $part[1]: "";
$step = isset($part[2])? $part[2]: "";
$db   = isset($part[3])? $part[3]: "";

$curl = "index.php";

switch ($request) {
    case '/' :
    case '' :
        require_once __DIR__ . '/index.php';
        break;
    case '/about' :
        require_once __DIR__ . '/about.php';
        break;
    default:
        // echo "request: $request<br/>";
        // echo "func: $func<br/>";
        // echo "step: $step<br/>";
        // echo "db: $db<br/>";
        require_once __DIR__ . "/index.php";

        break;
}
?>
