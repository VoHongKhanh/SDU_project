<?php
  require_once("sdu/sduConnection.php");

  try {
    $con = new sduConnection();
    echo "Connect successful!";
  } catch (Exception $e) {
    echo "Connect fail!". $e->getMessage();
  }
?>
