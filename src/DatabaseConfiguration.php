<?php 
$host = isset($_POST['txtServer'])  ? $_POST['txtServer']: "";
$uid  = isset($_POST['txtUsername'])? $_POST['txtUsername']: "";
$pwd  = isset($_POST['txtPassword'])? $_POST['txtPassword']: "";
if ($host == "" || $uid == "") {
	header('Location: index.php');
	exit();
} else {
    $sdu     = new sdu($host, $uid, $pwd);

    $_SESSION['sdu_host'] = $host;
    $_SESSION['sdu_uid']  = $uid;
    $_SESSION['sdu_pwd']  = $pwd;

    $conInfo = new sduConnectionInfo($sdu);
    $dbList  = $conInfo->getDatabaseList();

?>
	<div class="col-12 col-lg-6 col-xl-5 offset-xl-1 align-top" style="color: #fff">
	  <h3>Connection information</h3>
	  <ul>
	    <li><strong>Host</strong>: <?=$conInfo->getHost()?></li>
	    <li><strong>Client</strong>: <?=$conInfo->getClient()?></li>
	    <li><strong>Charset</strong>: <?=$conInfo->getCharset()?></li>
	    <li><strong>Collation</strong>: <?=$conInfo->getCollation()?></li>
	  </ul>
	  <h3>List of databases</h3>
	  <p><em>Number of database on server is <?=$conInfo->numberOfDatabase()?></em></p>
      <table class="table table-striped table-hover thead-dark table-sm table-responsive table-borderless">
        <thead>
          <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Charset</th>
            <th>Collation</th>
          </tr>
        </thead>
        <tbody>
<?php   
		$no = 0;
        foreach ($dbList as $db_) {
?>
          	<tr>
	            <td><?=++$no?>.</td>
	            <td><a href='?f=trial&s=db&d=<?=$db_->getName()?>'><?=$db_->getName()?></a></td>
	            <td><?=$db_->getCharset()?></td>
	            <td><?=$db_->getCollation()?></td>
          	</tr>
<?php   } ?>
        </tbody>
      </table>
	</div>
	<div class="col-md-5 col-lg-5 offset-lg-1 offset-xl-0 d-none d-lg-block phone-holder">
	  <div class="iphone-mockup"><img class="device" src="assets/img/crud.jpg"></div>
	</div>

<?php 
	$sdu->close();
}
?>