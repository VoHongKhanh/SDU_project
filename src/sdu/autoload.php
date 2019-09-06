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
?>
