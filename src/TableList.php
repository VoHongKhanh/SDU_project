<?php 
$host = isset($_SESSION['sdu_host'])? $_SESSION['sdu_host']: "";
$uid  = isset($_SESSION['sdu_uid']) ? $_SESSION['sdu_uid'] : "";
$pwd  = isset($_SESSION['sdu_pwd']) ? $_SESSION['sdu_pwd'] : "";

if ($host == "" || $uid == "") {
	header('Location: /index.php');
	exit();
} else {
    $sdu = new sdu($host, $uid, $pwd);

	$dbInfo = new sduDatabaseInfo($sdu, $db);
	$tbList = $dbInfo->getTableList();
?>
<script type="text/javascript">
var sdu_viewDivId = '#sduTableDetails';
var sdu_numTables = <?=$dbInfo->numberOfTable()?>;
function sdu_tb_info(tbName) {
	$.post("/trial/td", {db:"<?=$db?>", tb:tbName})
	 .done(function(data) {
    	$(sdu_viewDivId).html(data);
  	 });
}
function sdu_tb_gen(tbName) {
	alert('gen # ' + tbName);
}
function sdu_select_all_table() {
  v = $("#sdu_chkAll").prop('checked');
  for (i=1; i<=sdu_numTables; ++i) {
    $("#sdu_chk_" + i).attr("checked", v);
  }
}
</script>

	<div class="col-4 col-lg-4 col-xl-4 align-top" style="color: #fff">
	  <h3>
      <button type="button" class="btn btn-sm btn-outline-light" 
              onclick="location.href='/trial/db'" 
              data-toggle="tooltip" title="Back to select database">
        <i class="fa fa-backward"></i>
      </button>
      <?=$db?> # <?=$dbInfo->numberOfTable()?> tables</h3>
      <table class="table table-striped table-sm table-borderless">
        <thead>
          <tr>
            <th>No.</th>
            <th>Table</th>
            <th class="text-center">
              <input type="checkbox" class="form-check-input" id="sdu_chkAll" 
                     data-toggle="tooltip" title="Selects/unselects all tables" 
                     onclick="sdu_select_all_table()" />
              <button type="button" class="btn btn-sm btn-outline-light" 
                     data-toggle="tooltip" title="Generates function for all selected tables" 
                  onclick="sdu_tb_gen_all()">
                  <i class="fa fa-lightbulb-o"></i>
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
<?php   $no = 0;
        foreach ($tbList as $tb) {
          $pks = $tb->getPKs();
          $uks = $tb->getUKs();
          $fks = $tb->getFKs();
?>
          <tr onclick="sdu_tb_info('<?=$tb->getName()?>')" style="cursor: pointer">
            <td><?=++$no?>.</td>
            <td data-toggle="tooltip" title='Shows information of table "<?=$tb->getName()?>"'>
              <?=$tb->getName()?></a></td>
            <td class="text-center">
              <input type="checkbox" class="form-check-input" id="sdu_chk_<?=$no?>" value="<?=$tb->getName()?>" 
                     data-toggle="tooltip" title='Selects/unselects table "<?=$tb->getName()?>"' /> 
            	<button type="button" class="btn btn-sm btn-outline-light" 
            			onclick="sdu_tb_gen('<?=$tb->getName()?>')" 
                  data-toggle="tooltip" title='Generates function for table "<?=$tb->getName()?>"'>
					        <i class="fa fa-lightbulb-o"></i>
            	</button>
            </td>
          </tr>
<?php   } ?>
        </tbody>
      </table>
	</div>
	<div class="col-8 col-lg-8 col-xl-8 align-top" id="sduTableDetails" style="color: #fff">
	</div>
<?php 
	$sdu->close();
}
?>