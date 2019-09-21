UniqueuniqueUnique<?php
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

	$tbPrefix = "";
	if(strContains($tb, "_")) {
		$part     = explode("_", $tb);
		$tbPrefix = $part[0];
	}
	$tbPathList   = "list";
	$tbPathDelete = "del";
	$tbPathClear  = "clear";
	$tbPathAdd    = "add";
	$tbPathEdit   = "edit";
	$tbPathInfo   = "info";

	$tbFuncSearch = "search";
	$tbFuncSort   = "sort";
	$tbFuncPaging = "page";
	$tbFuncDelete = "delete";
	$tbFuncClear  = "clear";
	$tbFuncAdd    = "add";
	$tbFuncEdit   = "edit";
	$tbFuncInfo   = "info";
	$tbFuncStatus = "status";

	$controlSet = array();
	array_push($controlSet, ["type" => "text",     "label" => "Text field"]);
	array_push($controlSet, ["type" => "password", "label" => "Password field"]);
	array_push($controlSet, ["type" => "textarea", "label" => "Text area"]);
	array_push($controlSet, ["type" => "file",     "label" => "File field"]);
	array_push($controlSet, ["type" => "checkbox", "label" => "Checkbox"]);
	array_push($controlSet, ["type" => "radio",    "label" => "Radio group"]);
	array_push($controlSet, ["type" => "select",   "label" => "Combobox"]);
	array_push($controlSet, ["type" => "date",     "label" => "DatePicker"]);
	array_push($controlSet, ["type" => "datetime", "label" => "DateTimePicker"]);
	array_push($controlSet, ["type" => "email",    "label" => "Email field"]);
	array_push($controlSet, ["type" => "number",   "label" => "Number field"]);
	array_push($controlSet, ["type" => "regex",    "label" => "RegExp field"]);

?>
<script language="javascript" type="text/javascript">
var testAdd    = true;
var testEdit   = true;
var testUnique = true;
var testDelete = true;
var testClear  = false;
var testInfo   = true;
var numberOfField = <?=$tbInfo->numberOfField()?>;
function chkDelete_onClick() {
	testDelete = !testDelete;
	$('#txtDelete').prop("disabled", !testDelete);
}
function chkClear_onClick() {
	testClear = !testClear;
	$('#txtClear').prop("disabled", !testClear);
}
function chkInfo_onClick() {
	testInfo = !testInfo;
	$('#txtInfo').prop("disabled", !testInfo);
	$('.chkInfo').toggle();
}
function chkAdd_onClick() {
	testAdd = !testAdd;
	$('#txtAdd').prop("disabled", !testAdd);
	$('.chkAdd').toggle();
	uniqueChecking();
}
function chkEdit_onClick() {
	testEdit = !testEdit;
	$('#txtEdit').prop("disabled", !testEdit);
	$('.chkEdit').toggle();
	uniqueChecking();
}
function uniqueChecking() {
	testUnique = testAdd || testEdit;
	if (!testUnique) {
		$('.chkUnique').hide();
		for(i=1; i<=numberOfField; ++i)
			$('#sdu_tbl_'+i).hide();
	} else {
		$('.chkUnique').show();
		for(i=1; i<=numberOfField; ++i)
			$('#sdu_tbl_'+i).show();
	}
}
function repairData() {
	$('.value-label').prop("disabled", false);
	$('.value-default').prop("disabled", false);
	$('.value-type').prop("disabled", false);
	$('.value-ref').prop("disabled", false);
	return true;
}
</script>

<h3>
	<button type="button" class="btn btn-sm btn-outline-light"
					onclick="location.href='/trial/db'"
					data-toggle="tooltip" title="Back to select database">
		<i class="fa fa-backward"></i>
	</button>
	 GENERATES ADMIN FUNCTIONS FOR "<?=$db?>@<?=$tb?>"</h3>
<form action="/trial/ge" method="post" onsubmit="return repairData()" class="gen-form">
	<table class="table table-bordered table-condensed">
	   <thead>
	   <tr class="gen-subtitle-0">
	     <th colspan="8">
				 <button type="submit" class="btn btn-sm btn-outline-light"
								data-toggle="tooltip" title='Generates Admin functions for table "<?=$tb?>"'>
	         <i class="fa fa-lightbulb-o"></i>
				 </button>&nbsp;&nbsp;&nbsp;
	       DATALIST CONFIGURATION</th>
	   </tr>
	   <tr>
	     <th><label for="chkSearch"> Searching <br/><span class="glyphicon glyphicon-search"></span></label></th>
	     <th><label for="chkSort">   Sorting   <br/><span class="glyphicon glyphicon-sort"></span></label></th>
	     <th><label for="chkPage">   Paging    <br/><span class="glyphicon glyphicon-list"></span></label></th>
			 <th><label for="chkInfo">   Info      <br/><span class="glyphicon glyphicon-tags"></span></label></th>
	     <th><label for="chkAdd">    Add       <br/><span class="glyphicon glyphicon-plus-sign"></span></label></th>
	     <th><label for="chkEdit">   Edit      <br/><span class="glyphicon glyphicon-pencil"></span></label></th>
			 <th><label for="chkDelete"> Delete    <br/><span class="glyphicon glyphicon-trash"></span></label></th>
	     <th><label for="chkClear">  Clear     <br/><span class="glyphicon glyphicon-fire"></span></label></th>
	   </tr>
	   </thead>
	   <tbody>
	   <tr>
	     <td class="text-center"><input type="checkbox" checked="checked" name="chkSearch" id="chkSearch" value="<?=$tbFuncSearch?>" disabled="disabled" /></td>
	     <td class="text-center"><input type="checkbox" checked="checked" name="chkSort"   id="chkSort"   value="<?=$tbFuncSort?>"   disabled="disabled" /></td>
	     <td class="text-center"><input type="checkbox" checked="checked" name="chkPage"   id="chkPage"   value="<?=$tbFuncPaging?>" disabled="disabled" /></td>
			 <td class="text-center"><input type="checkbox" checked="checked" name="chkInfo"   id="chkInfo"   value="<?=$tbFuncInfo?>"   onclick="chkInfo_onClick()" /></td>
	     <td class="text-center"><input type="checkbox" checked="checked" name="chkAdd"    id="chkAdd"    value="<?=$tbFuncAdd?>"    onclick="chkAdd_onClick()" /></td>
	     <td class="text-center"><input type="checkbox" checked="checked" name="chkEdit"   id="chkEdit"   value="<?=$tbFuncEdit?>"   onclick="chkEdit_onClick()" /></td>
			 <td class="text-center"><input type="checkbox" checked="checked" name="chkDelete" id="chkDelete" value="<?=$tbFuncDelete?>" onclick="chkDelete_onClick()" /></td>
	     <td class="text-center"><input type="checkbox"                   name="chkClear"  id="chkClear"  value="<?=$tbFuncClear?>"  onclick="chkClear_onClick()" /></td>
	   </tr>
	   <tr class="gen-subtitle-0">
	     <th colspan="8">PATH CONFIGURATION</th>
	   </tr>
	   <tr>
	     <th class="text-center" colspan="2">Prefix</th>
	     <th class="text-center">List</th>
	     <th class="text-center">Delete</th>
	     <th class="text-center">Clear</th>
	     <th class="text-center">Add</th>
	     <th class="text-center">Edit</th>
	     <th class="text-center">Info</th>
	   </tr>
	   <tr>
	     <td  colspan="2">
				   <input name="txtPrefix" id="txtPrefix" class="form-control"        value="<?=$tbPrefix?>" /></td>
	     <td><input name="txtList"   id="txtList"   class="form-control subfix" value="<?=$tbPathList?>" /></td>
	     <td><input name="txtDelete" id="txtDelete" class="form-control subfix" value="<?=$tbPathDelete?>" /></td>
	     <td><input name="txtClear"  id="txtClear"  class="form-control subfix" value="<?=$tbPathClear?>" disabled="disabled" /></td>
	     <td><input name="txtAdd"    id="txtAdd"    class="form-control subfix" value="<?=$tbPathAdd?>" /></td>
	     <td><input name="txtEdit"   id="txtEdit"   class="form-control subfix" value="<?=$tbPathEdit?>" /></td>
	     <td><input name="txtInfo"   id="txtInfo"   class="form-control subfix" value="<?=$tbPathInfo?>" /></td>
	   </tr>
	   </tbody>
	</table>
	<table class="table table-bordered table-condensed">
	   <thead>
	   <tr class="gen-subtitle-0">
	     <th colspan="11">ADD & EDIT CONFIGURATION</th>
	   </tr>
	   </thead>
<?php
	$count = 0;
	foreach ($fdList as $fd) {
		++$count;

		$refValue = $fd->isForeignKey()? $fd->getRefTable()."@".$fd->getRefPK(): '';

		$isCreateUpade   = endsWith($fd->getName(), $tbFuncAdd) || endsWith($fd->getName(), $tbFuncEdit);
		$isStatus        = endsWith($fd->getName(), $tbFuncStatus);
		$isDisabled      = ($fd->isAutoIncrement() || $isCreateUpade)? 'disabled="disabled"': '';
		$isChecked       = ($isDisabled != '')? $isDisabled: ' checked="checked"';
		$isCreateChecked = $isStatus? '': $isChecked;
		$isUnique        = $isDisabled . (($fd->isPrimaryKey() || $fd->isUniqueKey())? ' checked="checked"': '');
		$label           = $fd->getName();
		$key             = $fd->getName();
		if ($fd->getComment() != "") {
			$part = explode("#", $fd->getComment());
			$label = trim($part[0]);
			if (strContains($label, ","))
				$label = explode(",", $label)[0];
			$key = count($part)>2? trim($part[1]): '';
			if ($isStatus) {
				if (strContains($part[1], ':')) {
					$key = str_replace(",", " # ", trim((explode(":", $part[1]))[1]));
				}
			}
		}

		$placeholder = "Xin mời nhập ".$label;
		$tooltiptext = $placeholder;

		$requiredMsg = $label." không được bỏ trống";
		$patternMsg  = $label." sai định dạng";

		$labelLower  = strtolower($label);
		$fieldType   = strtolower($fd->getType());
		$controlType = 'text';
		if (strContains($fieldType, 'text')) {
			$controlType = 'textarea';
		} else if ($fd->isForeignKey()) {
			$controlType = 'select';
		} else if (strContains($fieldType, 'time')) {
			$controlType = 'datetime';
		} else if (strContains($fieldType, 'date')) {
			$controlType = 'date';
		} else if ($isStatus) {
			$controlType = 'radio';
		} else if (strContainsOn($labelLower,
		                         ['hình', 'ảnh', 'image', 'picture',
														  'file', 'sound', 'video', 'document', 'data'])) {
			$controlType = 'file';
		} else if (strContainsOn($labelLower, ["mật", "khẩu", "pass"])) {
			$controlType = 'password';
		} else if (strContains(strtolower($fd->getName()), 'diachi')) {
			$controlType = 'textarea';
		} else if (strContains($fieldType, 'int')) {
			$controlType = 'number';
		} else if (strContainsOn($labelLower, ["mail", "thư"])) {
			$controlType = 'email';
		}
		$isPK = $fd->isPrimaryKey();
		$isShow = !$fd->isPrimaryKey() && !$controlType != 'password' && $controlType != 'textarea' || ($fieldType=='varchar' && $fd->getLength()<100);
?>
		<thead>
		<tr class="gen-subtitle-1">
			<th>No.</th>
			<th>List</th>
			<th class="chkInfo">Info</th>
			<th rowspan="2" class="chkAdd">Add</th>
			<th rowspan="2" class="chkEdit">Edit</th>
			<th class="chkUnique">Unique</th>
			<th>Field</th>
			<th>Label</th>
			<th>Type</th>
		</tr>
		</thead>
		<tbody>
		   <tr>
		     <td class="text-center" rowspan="2"><?=$count?>.</td>
		     <td class="chkList" class="text-center">
		       <input type="checkbox" name="chkList[]" id="chkList[]" value="<?=$fd->getName()?>" <?=(!$isShow? "": $isChecked)?> />
		     </td>
		     <td class="chkInfo" class="text-center">
		       <input type="checkbox" name="chkInfoCol[]" id="chkInfoCol[]" value="<?=$fd->getName()?>" <?=($isCreateUpade? '': 'checked="checked"')?> />
		     </td>
		     <td class="chkAdd" class="text-center">
		       <input type="checkbox" name="chkAddCol[]" id="chkAddCol[]" value="<?=$fd->getName()?>" <?=$isCreateChecked?> />
		     </td>
		     <td class="chkEdit" class="text-center">
		       <input type="checkbox" name="chkEditCol[]" id="chkEditCol[]" value="<?=$fd->getName()?>" <?=$isChecked?> />
		     </td>
		     <td class="chkUnique" class="text-center">
		       <input type="checkbox" name="chkUnique[]" id="chkUnique[]" value="<?=$fd->getName()?>" <?=$isUnique?> />
		     </td>
		     <td class="config-field"><?=$fd->getName()?></td>
		     <td><input class="form-control value-label" name="<?=$fd->getName()?>_label" value="<?=$label?>" /></td>
		     <td>
		        <select class="form-control value-type" name="<?=$fd->getName()?>_type" >
<?php
				 foreach ($controlSet as $ct) {
				  	$isSelected = $controlType == $ct["type"]? ' selected': '';
?>
			       <option value="<?=$ct['type']?>" <?=$isSelected?>><?=$ct['label']?></option>
<?php
		}
?>
		        </select>
		     </td>
		   </tr>
			 <tr id="sdu_tbl_<?=$count?>">
         <td colspan="9">
           <table class="table table-sm table-borderless subtable">
             <tr>
							 <td class="text-bold">Placeholder</td>
							 <td class="text-bold">Tooltiptext</td>
             </tr>
             <tr>
							 <td><input class="form-control value-default" name="<?=$fd->getName()?>_placehodler" value="<?=$placeholder?>" /></td>
							 <td><input class="form-control value-default" name="<?=$fd->getName()?>_tooltiptext" value="<?=$tooltiptext?>" /></td>
						 </tr>
             <tr>
               <td class="text-bold">Default</td>
               <td class="text-bold">Reference</td>
             </tr>
             <tr>
							 <td><input class="form-control value-default" name="<?=$fd->getName()?>_default" value="<?=$fd->getDefaultValue()?>" <?=$isDisabled?>/></td>
							 <td><input class="form-control value-ref" name="<?=$fd->getName()?>_ref" value="<?=$refValue?>" <?=$isDisabled?>/></td>
             </tr>
             <tr>
							 <td colspan="2">
							 	<table class="table table-sm table-borderless subtable">
									<tr>
										<td class="text-bold" width="70">Required</td> <td width="50"><input type="checkbox" name="chkRequired[]" id="chkRequired[]" value="<?=$fd->getName()?>" <?=($isPK? "": $isChecked)?> /></td>
										<td class="text-bold" width="100">Required error</td> <td><input class="form-control value-default" name="<?=$fd->getName()?>_requiredMsg" value="<?=$requiredMsg?>" /></td>
							 		</tr>
									<tr>
										<td class="text-bold" width="70">Pattern</td> <td width="50"><input type="checkbox" name="chkPattern[]" id="chkPattern[]" value="<?=$fd->getName()?>" /></td>
										<td class="text-bold" width="100">Pattern RegExp</td> <td><input class="form-control value-default" name="<?=$fd->getName()?>_patternRegExp" value="" <?=$isDisabled?>/></td>
							 		</tr>
									<tr>
										<td class="text-bold" width="70"></td> <td width="50"></td>
										<td class="text-bold" width="100">Pattern error</td> <td><input class="form-control value-default" name="<?=$fd->getName()?>_patternMsg" value="<?=$patternMsg?>" /></td>
							 		</tr>
							 	</table>
							 </td>
             </tr>
           </table>
         </td>
			 </tr>
		 </tbody>
<?php
	}
?>
		 <tfoot>
		 	<tr>
		 		<td colspan="10">
					<button type="submit" class="btn btn-sm btn-outline-light"
 								data-toggle="tooltip" title='Generates Admin functions for table "<?=$tb?>"'>
 	         <i class="fa fa-lightbulb-o"></i>
 				 </button>&nbsp;&nbsp;&nbsp;
				 GENERATES ADMIN FUNCTIONS FOR "<?=$db?>@<?=$tb?>"
		 		</td>
		 	</tr>
		 </tfoot>
	</table>
	<input type="hidden" name="dbName" value="<?=$db?>">
	<input type="hidden" name="tbName" value="<?=$tb?>">
</form>

<?php
	$sdu->close();
}
?>
