<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 *
 */
 $_SESSION['moduleType'] = 'timeMod';
require_once ROOT_PATH . '/plugins/PlugInFactoryException.php';
require_once ROOT_PATH . '/plugins/PlugInFactory.php';
// Check csv plugin available
$PlugInObj = PlugInFactory::factory("CSVREPORT");
if(is_object($PlugInObj) && $PlugInObj->checkAuthorizeLoginUser(authorize::AUTHORIZE_ROLE_ADMIN) && $PlugInObj->checkAuthorizeModule( $_SESSION['moduleType'])){
	$csvExportRepotsPluginAvailable = true;
}
$employmentStatuses = $records[0];
 if (isset($records[1])) {
 $subList = $records[1];
}
?>
<script type="text/javascript" src="../../scripts/archive.js"></script>
<?php include ROOT_PATH."/lib/common/calendar.php"; ?>
<script type="text/javascript">
var initialAction = "<?php echo $_SERVER['PHP_SELF']; ?>?timecode=Time&action=";
function returnLocDet(){
	var popup=window.open('CentralController.php?uniqcode=CST&VIEW=MAIN&esp=1','Locations','height=450,width=400,resizable=1');
	if(!popup.opener) popup.opener=self;
}

function validate() {
	startDate = strToDate($("txtStartDate").value, YAHOO.OrangeHRM.calendar.format);
	endDate = strToDate($("txtEndDate").value, YAHOO.OrangeHRM.calendar.format);
	errFlag=false;
	errors = new Array();

	warnings = _matchAutoCompletionFields();

	if (warnings.length > 0) {
		warningMessage = "<?php echo "{$lang_Time_Warning}: {$lang_Time_Warning_FieldsWereReset}"; ?>\n"
		for (i = 0; i < warnings.length; i++) {
			warningMessage += "  - " + warnings[i] + "\n";
		}
		alert(warningMessage);
	}

	if (!startDate || !endDate || (startDate > endDate)) {
		errors[errors.length] = "<?php echo $lang_Time_Errors_InvalidDateOrZeroOrNegativeRangeSpecified; ?>";
		errFlag=true;
	}
	if (errFlag) {
		errStr="<?php echo $lang_Common_EncounteredTheFollowingProblems; ?>\n";
		for (i in errors) {
			errStr+=" - "+errors[i]+"\n";
		}
		alert(errStr);
		return false;
	}
	return true;
}

function _matchAutoCompletionFields() {
	warnings = new Array();

	employeeName = $('txtUserEmpID').value;
	employeeFound = false;
	employeeFound = _matchRecords(employeeName, employees, 'cmbUserEmpID', ids, '<?php echo $lang_Time_Common_All; ?>', '-1');

	if (!employeeFound) {
		$('txtUserEmpID').value = '<?php echo $lang_Time_Common_All; ?>';
		warnings.push('<?php echo $lang_Time_Warning_NoMatchingEmployeeFound; ?>'.replace('#employeeName', employeeName));
	}
<?php if ($_SESSION['isAdmin'] == 'Yes') { ?>
	supervisorName = $('cmbRepEmpID').value;
	supervisorFound = false;
	supervisorFound = _matchRecords(supervisorName, employees, 'txtRepEmpID', ids, '<?php echo $lang_Time_Common_All; ?>', '-1');

	if (!supervisorFound) {
		$('cmbRepEmpID').value = '<?php echo $lang_Time_Common_All; ?>';
		warnings.push('<?php echo $lang_Time_Warning_NoMatchingSupervisorFound; ?>'.replace('#supervisorName', supervisorName));
	}
<?php } ?>
	return warnings;
}

function _matchRecords(needle, haystack, assignmentFieldId, assignmentRecords, defaultNeedle, defaultAssignmentValue) {
	if (needle == defaultNeedle) {
		$(assignmentFieldId).value = defaultAssignmentValue;
		return true;
	}
	for (i = 0; i < haystack.length; i++) {
		if (haystack[i] == needle) {
			$(assignmentFieldId).value = assignmentRecords[i];
			return true;
		}
	}
	return false;
}

function formReset() {
	document.frmEmp.txtUserEmpID.value = "<?php echo $lang_Time_Common_All; ?>";
	document.frmEmp.cmbUserEmpID.value = "-1";
	document.frmEmp.txtLocation.value = "<?php echo $lang_Time_Common_All; ?>";
	document.frmEmp.cmbLocation.value = "-1";
	document.frmEmp.cmbRepEmpID.value = "<?php echo $lang_Time_Common_All; ?>";
	document.frmEmp.txtRepEmpID.value = "-1";
	document.frmEmp.txtStartDate.value = "";
	document.frmEmp.txtEndDate.value = "";
	var statusDefault = document.getElementById("statusDefault");
	statusDefault.selected = true;
}

function exportData() {
		if (!validate()) {
			return;
		}
		var url = "../../plugins/csv/CSVController.php?path=<?php echo addslashes(ROOT_PATH) ?>&moduleType=<?php echo  $_SESSION['moduleType'] ?>&userEmpID=" + $('cmbUserEmpID').value + "&divisionId=" +  $('cmbLocation').value + "&supervisorId=" + $('txtRepEmpID').value + "&employmentStatusId=" + $('cmbEmploymentStatus').value + "&fromDate=" + $('txtStartDate').value + "&toDate=" +$('txtEndDate').value  + "&obj=<?php  echo   base64_encode(serialize($PlugInObj))?>";
        window.location = url;
}

employees = new Array();
ids = new Array();
<?php
$employees = $records['empList'];
for ($i=0;$i<count($employees);$i++) {
	echo "employees[" . $i . "] = '" . addslashes($employees[$i][1] . " " . $employees[$i][2]) . "';\n";
	echo "ids[" . $i . "] = \"" . $employees[$i][0] . "\";\n";
}
?>

YAHOO.OrangeHRM.container.init();
</script>

<style type="text/css">
label {
	width:150px;
}

#popLocLabel {
	width:auto;
}

#employeeSearchAC, #supervisorSearchAC {
    width:20em; /* set width here */
    padding-bottom:2em;
    position:relative;
    top:-10px
}

#employeeSearchAC, #supervisorSearchAC {
    z-index:9000; /* z-index needed on top instance for ie & sf absolute inside relative issue */
    float:left;
    margin-right:5px;
}
#txtUserEmpID, #cmbRepEmpID {
    _position:absolute; /* abs pos needed for ie quirks */
}

</style>

<div class="formpage">
	<div class="outerbox">
		<div class="mainHeading"><h2><?php echo $lang_Time_SelectTimesheetsTitle;?></h2></div>
		<form name="frmEmp" id="frmTimesheet" method="post" action="?timecode=Time&action=Timesheet_Print_Preview" onsubmit="return validate();">
		<?php if ($_SESSION['isAdmin'] == 'Yes' || $_SESSION['isSupervisor'] == 'Yes') { ?>
			<label for="txtUserEmpID"><?php echo $lang_Leave_Common_EmployeeName; ?></label>
			<div class="yui-skin-sam" style="float:left;margin-right:10px;">
	            <div id="employeeSearchAC" style="width:150px;">
					<input type="text" name="txtUserEmpID" id="txtUserEmpID" style="margin:10px 0px 2px 0px;" autocomplete="off"
						value="<?php echo (isset($_SESSION['txtUserEmpID']) && $_SESSION['posted'])?$_SESSION['txtUserEmpID']:$lang_Time_Common_All; ?>" />
					<div id="employeeSearchACContainer" style="margin:6px 0px 0px 0px;"></div>
				</div>
			</div>
			<input type="hidden" name="cmbUserEmpID" id="cmbUserEmpID" class="hide"
				value="<?php echo (isset($_SESSION['cmbUserEmpID']) && $_SESSION['posted'])?$_SESSION['cmbUserEmpID']:"-1"; ?>" />
			<label for="txtUserEmpID" class="sideHint"><?php echo $lang_Common_TypeHereForHints; ?></label>
		<?php } ?>
			<br class="clear" />

			<label for="txtLocation"><?php echo $lang_Time_Division; ?></label>
				<label for="txtLocation" id="popLocLabel">
				</label>
			<?php if ($_SESSION['isAdmin'] == 'Yes') { ?>
				<div class="yui-skin-sam" style="float:left;margin-right:10px;">
	            	<div id="supervisorSearchAC" style="width:150px;margin-top:10px;">
						<div id="supervisorSearchACContainer" style="margin:6px 0px 0px 10px;"></div>
					</div>
				</div>
				<label for="cmbRepEmpID" class="sideHint"><?php echo $lang_Common_TypeHereForHints; ?></label>


				<input type="button" id="btnStartDate" name="btnStartDate" value="  " class="calendarBtn" />
				<br class="clear" />

				<input type="button" id="btnEndDate" name="btnEndDate" value="  " class="calendarBtn" />
				<br class="clear" />

						The value/label of the following button is hardcoded because it is shown
						only if the plugin is installed and the label should come from the plugin
						and not from the language files
					-->
</div>
<script type="text/javascript">
//<![CDATA[
    if (document.getElementById && document.createElement) {
        roundBorder('outerbox');
    }

    YAHOO.OrangeHRM.autocomplete.ACJSArray = new function() {
	   	// Instantiate first JS Array DataSource
	   	this.oACDS = new YAHOO.widget.DS_JSArray(employees);

	   	// Instantiate AutoComplete for txtUserEmpID
	   	this.oAutoComp = new YAHOO.widget.AutoComplete('txtUserEmpID','employeeSearchACContainer', this.oACDS);
	   	this.oAutoComp.prehighlightClassName = "yui-ac-prehighlight";
	   	this.oAutoComp.typeAhead = false;
	   	this.oAutoComp.useShadow = true;
	   	this.oAutoComp.minQueryLength = 1;
	   	this.oAutoComp.textboxFocusEvent.subscribe(function(){
	   	    var sInputValue = YAHOO.util.Dom.get('txtUserEmpID').value;
	   	    if(sInputValue.length === 0) {
	   	        var oSelf = this;
	   	        setTimeout(function(){oSelf.sendQuery(sInputValue);},0);
	   	    }
	   	});
	}

<?php if ($_SESSION['isAdmin'] == 'Yes') { ?>
	YAHOO.OrangeHRM.autocomplete.ACJSArraySupervisor = new function() {
	   	// Instantiate first JS Array DataSource
	   	this.oACDS = new YAHOO.widget.DS_JSArray(employees);

	   	// Instantiate AutoComplete for cmbRepEmpID
	   	this.oAutoComp = new YAHOO.widget.AutoComplete('cmbRepEmpID','supervisorSearchACContainer', this.oACDS);
	   	this.oAutoComp.prehighlightClassName = "yui-ac-prehighlight";
	   	this.oAutoComp.typeAhead = false;
	   	this.oAutoComp.useShadow = true;
	   	this.oAutoComp.minQueryLength = 1;
	   	this.oAutoComp.textboxFocusEvent.subscribe(function(){
	   	    var sInputValue = YAHOO.util.Dom.get('cmbRepEmpID').value;
	   	    if(sInputValue.length === 0) {
	   	        var oSelf = this;
	   	        setTimeout(function(){oSelf.sendQuery(sInputValue);},0);
	   	    }
	   	});
	}
<?php } ?>

//]]>
</script>
</div>
<div id="cal1Container" style="position:absolute;" ></div>