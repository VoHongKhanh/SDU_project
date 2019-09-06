<?php
  require_once("sdu/autoload.php");

  $db = isset($_GET["db"])? $_GET["db"]: "";
  $tb = isset($_GET["tb"])? $_GET["tb"]: "";

  try {
    //----- test connection -----
    $sdu = new sdu();
    echo "Test connection # Connect successful!<hr/>";

    //----- test get all fields of table -----
    echo "Test get fields...<br/>";
    if ($db == "")
      echo "Please select any database on the last list!";
    else if ($tb == "")
      echo "Please select any table on the list below!";
    else {
      $sdu->setDB($db);
      $fdList = $sdu->getFDList($tb);
      echo "Number of fields of table $tb is ".(count($fdList))."<br/>";
      echo "<ol>";
      foreach ($fdList as $fd) {
        echo "<li>$fd->name</li>";
      }
      echo "</ol>";
    }
    echo "Test get fields finish!<hr/>";

    //----- test get all tables of database -----
    echo "Test get tables...<br/>";
    if ($db == "")
      echo "Please select any database on the last list!";
    else {
      $sdu->setDB($db);
      $tbList = $sdu->getTBList();
      echo "Number of tables of database $db is ".(count($tbList))."<br/>";
      echo "<ol>";
      foreach ($tbList as $tbname) {
        echo "<li><a href='?db=$db&tb=$tbname'>$tbname</a></li>";
      }
      echo "</ol>";
    }

    echo "Test get tables finish!<hr/>";

    //----- test get all databases on server -----
    echo "Test get databases...<br/>";

    $dbList = $sdu->getDBList();
    echo "Number of database on server is ".(count($dbList))."<br/>";
    echo "<ol>";
    foreach ($dbList as $dbname) {
      echo "<li><a href='?db=$dbname'>$dbname</a></li>";
    }
    echo "</ol>";
    echo "Test get databases finish!<hr/>";
  } catch (Exception $e) {
    echo "Connect fail!". $e->getMessage();
  } finally {
    $sdu->close();
  }
?>
