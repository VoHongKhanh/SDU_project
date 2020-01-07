<?php 
$host = isset($_POST['txtServer'])  ? $_POST['txtServer']: "";
$uid  = isset($_POST['txtUsername'])? $_POST['txtUsername']: "";
$pwd  = isset($_POST['txtPassword'])? $_POST['txtPassword']: "";

$host = isset($_SESSION['sdu_host'])? $_SESSION['sdu_host']: $host;
$uid  = isset($_SESSION['sdu_uid']) ? $_SESSION['sdu_uid'] : $uid;
$pwd  = isset($_SESSION['sdu_pwd']) ? $_SESSION['sdu_pwd'] : $pwd;

if ($host == "" || $uid == "") {
	header('Location: /index.php');
	exit();
} else {
    $sdu     = new sdu($host, $uid, $pwd);

    $_SESSION['sdu_host'] = $host;
    $_SESSION['sdu_uid']  = $uid;
    $_SESSION['sdu_pwd']  = $pwd;

    $conInfo = new sduConnectionInfo($sdu);
    $dbList  = $conInfo->getDatabaseList();

?>
	<div class="col-12 col-lg-7 col-xl-6 offset-xl-1 align-top" style="color: #fff">
	  <h3>
      <button type="button" class="btn btn-sm btn-outline-light" 
              onclick="location.href='?f=trial&s=sv'" 
              data-toggle="tooltip" title="Back to connection configuration">
          <i class="fa fa-backward"></i>
      </button>
      <?=$_SESSION['sdu_host']?> # <?=$conInfo->numberOfDatabase()?> databases</h3>
      <table class="table table-striped table-hover thead-dark table-sm table-borderless table_hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Database</th>
            <th>Charset</th>
            <th>Collation</th>
          </tr>
        </thead>
        <tbody>
<?php   
		$no = 0;
        foreach ($dbList as $db_) {
?>
          	<tr onclick="location.href='?f=trial&s=tb&d=<?=$db_->getName()?>'" style="cursor: pointer">
	            <td><?=++$no?>.</td>
	            <td><?=$db_->getName()?></td>
	            <td><?=$db_->getCharset()?></td>
	            <td><?=$db_->getCollation()?></td>
          	</tr>
<?php   } ?>
        </tbody>
      </table>
	</div>
	<div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
	  <div class="iphone-mockup"><img class="device" src="<?=getResourse('assets/img/crud.jpg')?>"></div>
	</div>

	<div class="col-12 col-lg-12 col-xl-12 offset-xl-1 align-top" style="color: #fff">
	  <h3>Connection information</h3>
	  <ul>
	    <li><strong>Host</strong>: <?=$conInfo->getHost()?></li>
	    <li><strong>Client</strong>: <?=$conInfo->getClient()?></li>
	    <li><strong>Charset</strong>: <?=$conInfo->getCharset()?></li>
	    <li><strong>Collation</strong>: <?=$conInfo->getCollation()?></li>
	  </ul>
	</div>

<?php 
	$sdu->close();
}
?>