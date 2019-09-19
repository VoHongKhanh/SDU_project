<?php
  require_once("sdu/autoload.php");

  $db = isset($_GET["db"])? $_GET["db"]: "";
  $tb = isset($_GET["tb"])? $_GET["tb"]: "";

  try {
    //----- test connection -----
    $sdu = new sdu();
    echo "Test connection # Connect successful!<hr/>";

    //##########################################################################
    //----- test get all fields of table -----
    echo "<div style='background-color: #dfd; border:1px solid #000; padding: 5px'>";
    echo "Test get fields...<br/>";
    if ($db == "")
      echo "Please select any database on the last list!";
    else if ($tb == "")
      echo "Please select any table on the list below!";
    else {
      $tbInfo = new sduTableInfo($sdu, $db, $tb);
      $fdList = $tbInfo->getFieldList();
      echo "Number of fields of table $tb is {$tbInfo->numberOfField()}<br/>";
    ?>
      <table cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Type</th>
            <th>Length</th>
            <th>AI</th>
            <th>PK</th>
            <th>Unique</th>
            <th>FK</th>
            <th>NULL</th>
            <th>Default</th>
            <th>Charset</th>
            <th>Collation</th>
            <th>Comment</th>
          </tr>
        </thead>
        <tbody>
<?php   $no = 0;
        foreach ($fdList as $fd) { ?>
          <tr>
            <td><?=++$no?>.</td>
            <td><?=$fd->getName()?></td>
            <td><?=$fd->getType()?></td>
            <!-- <td><?=($fd->isString() && $fd->getType()!="text")? $fd->getLength(): ""?></td> -->
            <td><?=$fd->getLength()?></td>
            <td><?=($fd->isAutoIncrement()? "X" : "")?></td>
            <td><?=($fd->isPrimaryKey()? "X" : "")?></td>
            <td><?=($fd->isUniqueField()? "X" : "")?></td>
            <td><?=($fd->isForeignKey()? ($fd->getRefTable()."@<br/>".$fd->getRefPK()) : "")?></td>
            <td><?=($fd->isNullable()? "X" : "")?></td>
            <td><?=$fd->getDefaultValue()?></td>
            <td><?=$fd->getCharset()?></td>
            <td><?=$fd->getCollation()?></td>
            <td><?=$fd->getComment()?></td>
          </tr>
<?php   } ?>
        </tbody>
      </table>
    <?php
    }
    echo "Test get fields finish!</h3><hr/>";

    //##########################################################################
    //----- test get all tables of database -----
    echo "<div style='background-color: #fdd; border:1px solid #000; padding: 5px'>";
    echo "Test get tables...<br/>";
    if ($db == "")
      echo "Please select any database on the last list!";
    else {
      $dbInfo = new sduDatabaseInfo($sdu, $db);
      $tbList = $dbInfo->getTableList();
      echo "Number of tables of database $db is {$dbInfo->numberOfTable()}<br/>";
?>
      <table cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>PK</th>
            <th>Unique</th>
            <th>FK</th>
            <th>Collation</th>
            <th>Engine</th>
            <th>Comment</th>
          </tr>
        </thead>
        <tbody>
<?php   $no = 0;
        foreach ($tbList as $tb) {
          $pks = $tb->getPKs();
          $uks = $tb->getUKs();
          $fks = $tb->getFKs();
?>
          <tr>
            <td><?=++$no?>.</td>
            <td><a href='?db=<?=$db?>&tb=<?=$tb->getName()?>'><?=$tb->getName()?></a></td>
            <td><?php foreach ($pks as $pk) echo $pk->getName()."<br/>"; ?></td>
            <td><?php foreach ($uks as $uk) echo $uk->getName()."<br/>"; ?></td>
            <td><?php foreach ($fks as $fk) echo $fk->getRefTable()."@".$fk->getName()."<br/>"; ?></td>
            <td><?=$tb->getCollation()?></td>
            <td><?=$tb->getEngine()?></td>
            <td><?=$tb->getComment()?></td>
          </tr>
<?php   } ?>
        </tbody>
      </table>
<?php
    }

    echo "Test get tables finish!</div><hr/>";

    //##########################################################################
    //----- test get all databases on server -----
    echo "<div style='background-color: #ddd; border:1px solid #000; padding: 5px'>";
    echo "Test get databases...<br/>";

    $conInfo = new sduConnectionInfo($sdu);
    $dbList = $conInfo->getDatabaseList();
    echo "Number of database on server is {$conInfo->numberOfDatabase()}<br/>";
    // echo "<ol>";
    // foreach ($dbList as $dbname) {
    //   echo "<li><a href='?db=$dbname'>$dbname</a></li>";
    // }
    // echo "</ol>";
    ?>
          <table cellspacing="5" cellpadding="5" border="1" style="border-collapse: collapse;">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Charset</th>
                <th>Collation</th>
              </tr>
            </thead>
            <tbody>
<?php       $no = 0;
            foreach ($dbList as $db_) {
?>
              <tr>
                <td><?=++$no?>.</td>
                <td><a href='?db=<?=$db_->getName()?>'><?=$db_->getName()?></a></td>
                <td><?=$db_->getCharset()?></td>
                <td><?=$db_->getCollation()?></td>
              </tr>
<?php   } ?>
        </tbody>
      </table>
<?php

    echo "Test get databases finish!<hr/>";

    echo "<div style='background-color: #aaa'>";
    echo "   <h3>Connection's information</h3>";
    echo "   <b>Host</b>: {$conInfo->getHost()}<br/>";
    echo "   <b>Client</b>: {$conInfo->getClient()}<br/>";
    echo "   <b>Charset</b>: {$conInfo->getCharset()}<br/>";
    echo "   <b>Collation</b>: {$conInfo->getCollation()}<br/>";
    echo "</div></div>";
  } catch (Exception $e) {
    echo "Connect fail!". $e->getMessage();
  } finally {
    $sdu->close();
  }
?>
