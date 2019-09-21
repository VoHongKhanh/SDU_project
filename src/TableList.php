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
			$("#showHide_tableListPanel span").first().html("Show table list panel");
			$("#showHide_tableListPanel i").first().addClass("fa-eye");
			$("#showHide_tableListPanel i").first().removeClass("fa-eye-slash");
			$("#tableListPanel").slideUp();
			$("#sduTableDetails").fadeIn();
  	});
}
function sdu_tb_gen(tbName) {
	$.post("/trial/gf", {db:"<?=$db?>", tb:tbName})
	 .done(function(data) {
    	$(sdu_viewDivId).html(data);
			$("#showHide_tableListPanel span").first().html("Show table list panel");
			$("#showHide_tableListPanel i").first().addClass("fa-eye");
			$("#showHide_tableListPanel i").first().removeClass("fa-eye-slash");
			$("#tableListPanel").slideUp();
			$("#sduTableDetails").fadeIn();
 	  });
}
function sdu_select_all_table() {
  v = $("#sdu_chkAll").prop('checked');
  for (i=1; i<=sdu_numTables; ++i) {
    $("#sdu_chk_" + i).attr("checked", v);
  }
}
function btnShowTableListPanel_onClick() {
	$("#showHide_tableListPanel span").first().html(($("#tableListPanel").is(':hidden')? "Hide": "Show") + " table list panel");
	$("#showHide_tableListPanel i").first().toggleClass("fa-eye");
	$("#showHide_tableListPanel i").first().toggleClass("fa-eye-slash");
	$("#tableListPanel").slideToggle();
}
</script>
	<div class="col-12 col-lg-12 col-xl-12 align-top" style="color: #fff">
		<button type="button" class="btn btn-sm btn-outline-light"
						id="showHide_tableListPanel"
						onclick="btnShowTableListPanel_onClick()">
			<i class="fa fa-eye-slash"></i> <span>Hide table list panel</span>
		</button><br/><br/>
	</div>
	<div class="col-12 col-lg-12 col-xl-12 align-top table-list"
			 style="color: #fff" id="tableListPanel">
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
          <tr style="cursor: default">
            <td><?=++$no?>.</td>
            <td data-toggle="tooltip" title='Shows information of table "<?=$tb->getName()?>"'
							  onclick="sdu_tb_info('<?=$tb->getName()?>')" style="cursor: pointer">
              <?=$tb->getName()?></a></td>
            <td class="text-center">
              <input type="checkbox" class="form-check-input" id="sdu_chk_<?=$no?>" value="<?=$tb->getName()?>"
                     data-toggle="tooltip" title='Selects/unselects table "<?=$tb->getName()?>"' />
            	<button type="button" class="btn btn-sm btn-outline-light"
            			onclick="sdu_tb_gen('<?=$tb->getName()?>')"
                  data-toggle="tooltip" title='Generates function for table "<?=$tb->getName()?>"'>
									<i class="fa fa-wrench"></i>
            	</button>
            </td>
          </tr>
<?php   } ?>
        </tbody>
      </table>
	</div>
	<div class="col-12 col-lg-12 col-xl-12 align-top" id="sduTableDetails" style="color: #fff">
	</div>
<?php
	$sdu->close();
}
?>
