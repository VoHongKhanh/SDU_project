<?php
require_once("autoload.php");

$host = isset($_SESSION['sdu_host'])? $_SESSION['sdu_host']: "";
$uid  = isset($_SESSION['sdu_uid']) ? $_SESSION['sdu_uid'] : "";
$pwd  = isset($_SESSION['sdu_pwd']) ? $_SESSION['sdu_pwd'] : "";

$db   = isset($_POST['db'])? $_POST['db']: "";
$tb   = isset($_POST['tb'])? $_POST['tb']: "";

if ($host == "" || $uid == "") {
	echo "<h3>Can't connect to database server</h3>";
} else if ($db == "" || $tb == "") {
  echo "<h3>Invalid database or table</h3>";
} else {
  $sdu = new sdu($host, $uid, $pwd);
  $tbInfo = new sduTableInfo($sdu, $db, $tb);
  $fdList = $tbInfo->getFieldList();
?>
  <h3><?=$db?>@<?=$tb?></h3>
  <ul>
    <li><strong>Collation</strong>: <?=$tbInfo->getCollation()?></li>
    <li><strong>Engine</strong>: <?=$tbInfo->getEngine()?></li>
    <li><strong>Comment</strong>: <?=$tbInfo->getComment()?></li>
  </ul>
  <h3>List of <?=$tbInfo->numberOfField()?> fields</h3>
  <table class="table table-striped table-sm table-borderless">
    <thead>
      <tr>
        <th>No.</th>
        <th>Field</th>
        <th>Type</th>
        <th>Length</th>
        <th>AI</th>
        <th>PK</th>
        <th>Unique</th>
        <th>FK</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
<?php
    $no = 0;
    foreach ($fdList as $fd) {
?>
      <tr style="cursor: default">
        <td><?=++$no?>.</td>
        <td><?=$fd->getName()?></td>
        <td><?=$fd->getType()?></td>
        <td><?=$fd->getLength()?></td>
        <td><?=($fd->isAutoIncrement()? "X" : "")?></td>
        <td><?=($fd->isPrimaryKey()? "X" : "")?></td>
        <td><?=($fd->isUniqueField()? "X" : "")?></td>
        <td><?=($fd->isForeignKey()? ($fd->getRefTable()."@<br/>".$fd->getRefPK()) : "")?></td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-light"
                  data-toggle="collapse" data-target="#sdu_tbl_<?=$no?>"
                  data-toggle="tooltip"
                  title="Shows more information: isNull, Default value, Charset, Collation and Comment">
              <i class="fa fa-info-circle"></i>
          </button>
        </td>
      </tr>
      <tr id="sdu_tbl_<?=$no?>" class="collapse">
        <td colspan="11">
          <table class="table table-sm table-borderless subtable">
            <thead>
              <tr>
                <th>NULL</th>
                <th>Default</th>
                <th>Charset</th>
                <th>Collation</th>
                <th>Comment</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?=($fd->isNullable()? "X" : "")?></td>
                <td><?=$fd->getDefaultValue()?></td>
                <td><?=$fd->getCharset()?></td>
                <td><?=$fd->getCollation()?></td>
                <td><?=$fd->getComment()?></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
<?php } ?>
    </tbody>
  </table>
<?php
	$sdu->close();
}
?>
