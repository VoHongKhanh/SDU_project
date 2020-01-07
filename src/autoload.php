<?php
/**
 * Creates session instance
 */
session_start();

/**
 * Report all for MySQLi
 */
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

/**
 * include class sdu
 */
require_once("sdu/sdu.php");

/**
 * include class sduConnectionInfo
 */
require_once("sdu/sduConnectionInfo.php");

/**
 * include class sduDatabaseInfo
 */
require_once("sdu/sduDatabaseInfo.php");

/**
 * include class sduFieldInfo
 */
require_once("sdu/sduFieldInfo.php");

/**
 * include class sduTableInfo
 */
require_once("sdu/sduTableInfo.php");

/**
 * import PhpVnDataGenerator library
 */
require_once("PhpVnDataGenerator/VnBigNumber.php");
require_once("PhpVnDataGenerator/VnBase.php");
require_once("PhpVnDataGenerator/VnFullname.php");
require_once("PhpVnDataGenerator/VnPersonalInfo.php");

use PhpVnDataGenerator\VnBase;
use PhpVnDataGenerator\VnBigNumber;
use PhpVnDataGenerator\VnFullname;
use PhpVnDataGenerator\VnPersonalInfo;

$rootURL = "http://sdu.com:1000/";

function getResourse($link) {
    return $GLOBALS['rootURL'].$link;
}

function strContains($source, $sub) {
    return strpos($source, $sub) !== false;
}

function strContainsOn($source, $arr) {
  foreach ($arr as $it)
    if (strContains($source, $it))
      return true;
  return false;
}

function startsWith($haystack, $needle) {
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

?>
