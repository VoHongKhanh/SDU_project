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
require_once("sdu.php");

/**
 * include class sduConnectionInfo
 */
require_once("sduConnectionInfo.php");

/**
 * include class sduDatabaseInfo
 */
require_once("sduDatabaseInfo.php");

/**
 * include class sduFieldInfo
 */
require_once("sduFieldInfo.php");

/**
 * include class sduTableInfo
 */
require_once("sduTableInfo.php");
?>
