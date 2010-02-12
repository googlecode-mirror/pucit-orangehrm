<?php
require_once "../../language/default/lang_default_full.php";

$categories = array(array($lang_Menu_Admin_CompanyInfo,$lang_Menu_Admin_CompanyInfo_Gen,$lang_Menu_Admin_CompanyInfo_Locations,$lang_Menu_Admin_CompanyInfo_CompStruct,$lang_Menu_Admin_Company_Property)
    ,array($lang_Menu_Admin_Job,$lang_Menu_Admin_Job_JobTitles,$lang_Menu_Admin_Job_JobSpecs,$lang_Menu_Admin_Job_PayGrades,$lang_Menu_Admin_Job_EmpStatus,$lang_Menu_Admin_Job_EEO),
    array($lang_Menu_Admin_Quali,$lang_Menu_Admin_Quali_Education,$lang_Menu_Admin_Quali_Licenses),array($lang_Menu_Admin_Skills."New",$lang_Menu_Admin_Skills_Skills,$lang_Menu_Admin_Skills_Languages),
    array($lang_Menu_Admin_Memberships."New",$lang_Menu_Admin_Memberships_MembershipTypes,$lang_Menu_Admin_Memberships_Memberships),array($lang_Menu_Admin_NationalityNRace,$lang_Menu_Admin_NationalityNRace_Nationality,$lang_Menu_Admin_NationalityNRace_EthnicRaces),
    array($lang_Menu_Admin_Users,$lang_Menu_Admin_Users_HRAdmin,$lang_Menu_Admin_Users_ESS,$lang_Menu_Admin_Users_UserGroups),array($lang_Menu_Admin_EmailNotifications,$lang_Menu_Admin_EmailConfiguration,$lang_Menu_Admin_EmailSubscribe),
    array($lang_Menu_Admin_ProjectInfo,$lang_Menu_Admin_Customers,$lang_Menu_Admin_Projects,$lang_Admin_ProjectActivities),array($lang_Menu_Admin_DataImportExport,$lang_Menu_Admin_DataExport,$lang_Menu_Admin_DataExportDefine,$lang_Menu_Admin_DataImport,$lang_Menu_Admin_DataImportDefine),
    array($lang_Menu_Admin_CustomFields));
//$styleSheet = $_GET['styleSheet'] ;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


<script type="text/javascript" src="../../scripts/archive.js"></script>

<script type="text/javascript"><!--//--><![CDATA[//><!--
categoryNames = new Array();
<?php
    if($categories) {
        print "\tcategoryNames.push(\"Admin\");\n";
        foreach($categories as $subCat) {
            for($i=0;$i<count($subCat);$i++){
                
               print "\tcategoryNames.push(\"{$subCat[$i]}\");\n";
            
            }
        }
    }
?>

function displayLayer(paneId) {

        var splitArray = paneId.split("-");
        showPane(parseInt(splitArray[0]),splitArray[1]);
        document.frmEmp.pane.value = paneId;
        document.frmEmp.currentPane.value = "MD001"+splitArray[1];
}

function showPane(paneIndex,categoryIndex) {
        
        var allPanes = categoryNames;
        var paneId = allPanes[paneIndex];
        var numPanes = allPanes.length;
        for (i=0; i< numPanes; i++) {
	    pane = allPanes[i];
            if (pane != paneId) {
                var link = document.getElementById(pane + 'Link');
                    if (link && (link.className.indexOf('current') > -1)) {
                        link.className = '';
                    }
           }
        }
        var paneDiv = document.getElementById('general');

        if (paneDiv.className.indexOf('currentpanel') > -1) {
		paneDiv.className = paneDiv.className.replace(/\scurrentpanel\b/,'');
	}
	var currentPanel = document.getElementById('general');
	if (currentPanel.className.indexOf('currentpanel') == -1) {
		currentPanel.className += ' currentpanel';
	}
        
        if(paneIndex != 1 && paneIndex != 6 && paneIndex != 12 && paneIndex != 15 && paneIndex != 18 && paneIndex != 21 && paneIndex != 24 && paneIndex != 28 && paneIndex != 31 && paneIndex != 35 && paneIndex != 40)
        {
            var currentLink = document.getElementById(paneId + 'Link');
            if (currentLink && (currentLink.className.indexOf('current') == -1)) {
                currentLink.className = 'current';
            }
            var catId = categoryIndex.charCodeAt(0) - 96;
            var objects = document.getElementsByName("chkcategory"+catId+"[]");
            if(objects[categoryIndex.charCodeAt(1) - 97].checked)
                objects[categoryIndex.charCodeAt(1) - 97].checked = false;
            else
                objects[categoryIndex.charCodeAt(1) - 97].checked = true;
        }
        layer = document.getElementById('mainHeadingGeneral');
        layer.innerHTML=allPanes[paneIndex];
}
function resetChkBoxes()
{
    document.getElementById('chkAdd').checked = false;
    document.getElementById('chkEdit').checked = false;
    document.getElementById('chkDelete').checked = false;
    document.getElementById('chkView').checked = false;
}

function showHideSubMenu(link) {

        var allCategory = new Array('Company InfoLink','JobLink','QualificationLink','SkillsNewLink','MembershipsNewLink','Nationality & RaceLink','UsersLink','Email NotificationsLink','Project InfoLink','Data Import/ExportLink','Custom FieldsLink');
        var uldisplay;
	var newClass;
        var oldulDisplay;
        
        if (link.className == 'expanded') {

		// Need to hide
	    uldisplay = 'none';
	    newClass = 'collapsed';

	} else {

		// Need to show
	    uldisplay = 'block';
	    newClass = 'expanded';
            oldulDisplay = 'none';
	}
        for(var i=0;i<allCategory.length;i++)
        {
            if(allCategory[i] == link.id)
            {
                var parent = link.parentNode;
                uls = parent.getElementsByTagName('ul');
                for(var j=0; j<uls.length; j++) {
                    ul = uls[j].style.display = uldisplay;
                }
            }
            else
            {
                var categoryElement = document.getElementById(allCategory[i]);
                if(categoryElement.className == 'expanded')
                {
                    var parent = categoryElement.parentNode;
                    uls = parent.getElementsByTagName('ul');
                    for(var j=0; j<uls.length; j++) {
                        ul = uls[j].style.display = oldulDisplay;
                    }
                    categoryElement.className = 'collapsed';
                }
            }
        }
	link.className = newClass;
}

tableDisplayStyle = "table";
function doHandleAll(element,id)
{
        var elementName = element.name;
        if(document.getElementById(elementName).checked == false){
		doUnCheckAll(id);
	}
	else if(document.getElementById(elementName).checked == true){
		doCheckAll(id);
        }
	
}
function doCheckAll(id)
{
    var objects = document.getElementsByName("chkcategory"+id+"[]");
    var chkLength = objects.length;

    for(var i=0;i<chkLength;i++)
    {
        objects[i].checked = true;
    }
    
}

function doUnCheckAll(id)
{
    var objects = document.getElementsByName("chkcategory"+id+"[]");
    var chkLength = objects.length;

    for(var i=0;i<chkLength;i++)
    {
        objects[i].checked = false;
    }
}

function initModule()
{
    showHideSubMenu(document.getElementById("Company InfoLink"));
}
//--><!]]></script>
<!--[if IE]>
<script type="text/javaScript">
	tableDisplayStyle = "block";
</script>
<![endif]-->

<script type="text/javascript" src="../../themes/<?php echo $styleSheet;?>/scripts/style.js"></script>
<link href="../../themes/<?php echo $styleSheet;?>/css/style.css" rel="stylesheet" type="text/css"/>
<!--[if lte IE 6]>
<link href="../../themes/<?php echo $styleSheet; ?>/css/IE6_style.css" rel="stylesheet" type="text/css"/>
<![endif]-->
<!--[if IE]>
<link href="../../themes/<?php echo $styleSheet; ?>/css/IE_style.css" rel="stylesheet" type="text/css"/>
<![endif]-->
<style type="text/css">
    <!--

    input[type=text] {
		border-top: 0px;
		border-left: 0px;
		border-right: 0px;
		border-bottom: 1px solid #888888;
	}

    .pimpanel {
	    position:absolute;
	    left:-9999px;
	}
	.currentpanel {
		margin-top: 10px;
                left:180px;
        }
	#pimleftmenu {
	    display:block;
	    float: left;
	    background: #FFFBED;
	    padding: 2px 2px 2px 2px;
	    margin: 10px 0px 0px 5px;
	}
	#pimleftmenu ul {
	    list-style-type: none;
	    padding-left: 0;
	    margin-left: 0;
	    width: 14em;
	}

	#pimleftmenu ul.pimleftmenu li {
	    list-style-type:none;
	    margin-left: 0;
	    margin-bottom: 1px;
		padding-left:5px;
	}

	#pimleftmenu ul li.parent {
	    padding-left: 0px;
	    padding-top:4px;
	    font-weight: bold;
	}

	#pimleftmenu ul.pimleftmenu li a {
	    display:block;
	    outline: 0;
		padding: 2px 2px 2px 4px;
		text-decoration: none;
		background:#FAD163 none repeat scroll 0 0;
		border-color:#CD8500 #8B5A00 #8B5A00 #CD8500;
		border-style:solid;
		border-width:1px;
		color:#d87415;
		font-size: 11px;
		font-weight:bold;
		text-align: left;
	}
	#pimleftmenu ul.pimleftmenu li a:hover {
		color: #FFFBED;
		background-color: #e88d1e;
	}

	#pimleftmenu ul.pimleftmenu li a.current {
		color: #FFFBED;
		background-color: #e88d1e;
	}

	#pimleftmenu ul.pimleftmenu li a.collapsed,
	#pimleftmenu ul.pimleftmenu li a.expanded {
	    display:block;
	    outline: 0;
		padding: 2px 2px 2px 4px;
		text-decoration: none;
		border: 0 ;
		color: #CC6600;
		font-size: 11px;
		font-weight:bold;
		text-align: left;
	}

	#pimleftmenu ul.pimleftmenu li a.expanded {
		background: #FFFBED url(../../themes/orange/icons/expanded.gif) no-repeat center right;
	}

	#pimleftmenu ul.pimleftmenu li a.collapsed {
		background: #FFFBED url(../../themes/orange/icons/collapsed.gif) no-repeat center right;
		border-bottom: 1px solid #d87415;
	}

	#pimleftmenu ul.pimleftmenu li a.collapsed:hover span,
	#pimleftmenu ul.pimleftmenu li a.expanded:hover span {
		color: #8d4700;
	}


	#pimleftmenu ul span {
	    display:block;
	}

	#pimleftmenu li.parent span.parent {
		color: #CC6600;
	}

	#pimleftmenu ul span span {
	    display:inline;
	    text-decoration:underline;
	}

        div.mainHeading {
	padding: 1px 0px 4px 8px;
	width:260px;
	border:0;
	background-color: #FAD163;
	color: black;
	text-align:left;
}
    #wrapper
    {
        width:260px;
    }

    input.formCheckboxWide {
    display: block;
    float: left;
    margin: 22px 30px 10px 0px;
}

label{
    float:left;
    text-align: left;
    width: 50px;
    padding: 10px 10px 10px 20px;
}
    -->
</style>
<!--[if IE]>

<style type="text/css">
	#pimleftmenu ul.pimleftmenu li {
	    display:inline;
	}

	/* following style may not be needed */
	#pimleftmenu ul.pimleftmenu {
	    height:auto;
	}

	/* Give layout in IE (hasLayout) */
	#pimleftmenu a {
	    zoom: 1;
	}

</style>
<![endif]-->
</head>
<body>
<script type="text/javaScript"><!--//--><![CDATA[//><!--
  YAHOO.OrangeHRM.container.init();
//--><!]]></script>
<?php
$ugDet = $this ->popArr['ugDet'];
?>
<div id="cal1Container"></div>

<div align="right" id="status" style="display: none;"><img src="../../themes/beyondT/icons/loading.gif" alt="" width="20" height="20" style="vertical-align:bottom;"/> <span style="vertical-align:text-top"><?php echo $lang_Common_LoadingPage; ?>...</span></div>

<form name="frmEmp" id="frmEmp" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?uniqcode=UGR" enctype="multipart/form-data">

<input type="hidden" name="pane" value="" />
<input type="hidden" name="currentPane" id="currentPane" value="" />
<input type="hidden" name="Module" id="Module" value="MOD001" />
<input type="hidden" name="categoryCount" id="categoryCount" value="11" />
<input type="hidden" name="STAT" id="STAT" value="ADD" />
<input type="hidden" name="txtUserGroupID" id="txtUserGroupID" value="<?php echo $ugDet[0][0];?>" />

<label for="chkAdmin"><?php echo "Admin"; ?></label>
<input type="checkbox" name="cmbModuleID" id="cmbModuleID" value="MOD001" class="formCheckboxWide"/>
<br class="clear"/>

<div id="pimleftmenu">
	<ul class="pimleftmenu">

            <?php 
                    $categoryChar = 97;
                    $count = 1;
                    $subCategoryCount = "";
                    for($i=0;$i<count($categories);$i++){

                        $category = $categories[$i];
                        $flag=0;
                        $subCategoryChar = 97;
                        for($j=0;$j<count($category);$j++){

                            if($j == 0){
                ?>
                            <li class="l1 parent">
                                <a href="javascript:displayLayer('<?php echo ($count).'-'.chr($categoryChar)?>')"  id="<?php echo $categories[$i][$j].'Link'?>" class="collapsed" onclick="showHideSubMenu(this);">
                                    <span><input type="checkbox" class="checkbox" name="<?php echo $categories[$i][$j].'Chk'?>" id="<?php echo $categories[$i][$j].'Chk'?>" onclick="doHandleAll(this,<?php echo ($i+1);?>)"/><?php echo strtoupper(" ".$categories[$i][$j]);?></span></a>
                            <?php }else
                                   {
                                        if(!$flag){
                                            $flag=1;
                            ?>
                                            <ul class="l2" style="display:none;">
                            <?php }?>
				<li class="l2">
					<a href="javascript:displayLayer('<?php echo ($count).'-'.chr($categoryChar).chr($subCategoryChar-1)?>')" id="<?php echo $categories[$i][$j].'Link'?>" >
                                            <span><input type="checkbox" class="checkbox" name="<?php echo 'chkcategory'.($i+1).'[]'?>" id="<?php echo 'chkcategory'.($i+1).'[]'?>" value="<?php echo "MOD001".chr($categoryChar).chr($subCategoryChar-1)?>"/><?php echo strtoupper(" ".$categories[$i][$j]);?></span></a></li>
			<?php }
                            if($j == count($category)-1){?>
                                </ul>
                       <?php }
                            $count++;
                            $subCategoryChar++;
                        }
                        
                        $subCategoryCount .= ($j-1)."-";
                            $categoryChar++;?>
                            </li>
                       <?php }
                        ?>
	</ul>
</div>
<input type="hidden" name="subCategoryCount" id="subCategoryCount" value="<?php echo $subCategoryCount;?>" />
<div id="general" class="pimpanel formpage2col currentpanel">
    <div id="wrapper">
	    <div class="outerbox">
                <div class="mainHeading"><h2 id="mainHeadingGeneral"><?php echo $lang_Menu_Admin_CompanyInfo; ?></h2></div>
	    	<?php require_once "../../templates/maintenance/moduleRight.php"; ?>	    </div>
	    <br class="clear"/>
    </div>
</div>
</form>
	<script type="text/javaScript"><!--//--><![CDATA[//><!--
    	if (document.getElementById && document.createElement) {
 			roundBorder('outerbox');
		}
        initModule();
	</script>
		</body>
</html>
