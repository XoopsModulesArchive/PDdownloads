<?php
/**
 * $Id: brokendown.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */
include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

$op = '';

if (isset($_POST))
{
	foreach ($_POST as $k => $v)
	{
		${$k} = $v;
	}
}

if (isset($_GET))
{
	foreach ($_GET as $k => $v)
	{
		${$k} = $v;
	}
}

function createcat($cid = 0)
{
	include_once '../class/PDd_lists.php';
	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
	if (empty($mydirname)){
		include '../include/mydirname.php';
	}

	global $xoopsDB, $myts, $xoopsModuleConfig, $totalcats, $xoopsModule;

	$lid = 0;
	$title = '';
	$imgurl = '';
	$description = '';
	$pid = '';
	$weight = 0;
	$nohtml = 0;
	$nosmiley = 0;
	$noxcodes = 0;
	$noimages = 0;
	$nobreak = 1;

	$spotlighttop = 0;
	$spotlighthis = 0;
	$heading = _AM_PDD_CCATEGORY_CREATENEW;
	$totalcats = PDd_totalcategory();

	if ($cid)
	{
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=$cid";
		$cat_arr = $xoopsDB -> fetchArray($xoopsDB -> query($sql));
		$title = $myts -> htmlSpecialChars($cat_arr['title']);
		$imgurl = $myts -> htmlSpecialChars($cat_arr['imgurl']);
		$description = $myts -> htmlSpecialChars($cat_arr['description']);
		$nohtml = intval($cat_arr['nohtml']);
		$nosmiley = intval($cat_arr['nosmiley']);
		$noxcodes = intval($cat_arr['noxcodes']);
		$noimages = intval($cat_arr['noimages']);
		$nobreak = intval($cat_arr['nobreak']);
		$spotlighthis = intval($cat_arr['spotlighthis']);
		$spotlighttop = intval($cat_arr['spotlighttop']);
		$weight = $cat_arr['weight'];
		$heading = _AM_PDD_CCATEGORY_MODIFY;

		$member_handler = & xoops_gethandler('member');
		$group_list = & $member_handler -> getGroupList();

		$gperm_handler = & xoops_gethandler('groupperm');
		$groups = $gperm_handler -> getGroupIds("PDDownCatPerm{$mydirnumber}", $cid, $xoopsModule -> getVar('mid'));
		$groups = $groups;
	}
	else
	$groups = true;

	$sform = new XoopsThemeForm($heading, "op", xoops_getenv('PHP_SELF'), "post", true);
	$sform -> setExtra('enctype="multipart/form-data"');

	$sform -> addElement(new XoopsFormSelectGroup(_AM_PDD_FCATEGORY_GROUPPROMPT, "groups", true, $groups, 5, true));
	if ($totalcats > 0)
	{
		$mytreechose = new XoopsTree($xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat"), "cid", "pid");
		ob_start();
		$mytreechose -> makeMySelBox("title", "title", 0 , 1, "pid");
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_FCATEGORY_SUBCATEGORY, ob_get_contents()));
		ob_end_clean();
	}
	$sform -> addElement(new XoopsFormText(_AM_PDD_FCATEGORY_TITLE, 'title', 50, 80, $title), true);
	$sform -> addElement(new XoopsFormText(_AM_PDD_FCATEGORY_WEIGHT, 'weight', 10, 80, $weight), false);

	$graph_array = & PDsLists :: getListTypeAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['catimage'], $type = "images");
	$indeximage_select = new XoopsFormSelect('', 'imgurl', $imgurl);
	$indeximage_select -> addOptionArray($graph_array);
	$indeximage_select -> setExtra("onchange='showImgSelected(\"image\", \"imgurl\", \"" . $xoopsModuleConfig['catimage'] . "\", \"\", \"" . XOOPS_URL . "\")'");
	$indeximage_tray = new XoopsFormElementTray(_AM_PDD_FCATEGORY_CIMAGE, '&nbsp;');
	$indeximage_tray -> addElement($indeximage_select);
	if (!empty($imgurl))
	$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['catimage'] . "/" . $imgurl . "' name='image' id='image' alt='' />"));
	else
	$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />"));

	$sform -> addElement($indeximage_tray);
	$sform -> addElement(new XoopsFormDhtmlTextArea(_AM_PDD_FCATEGORY_DESCRIPTION, 'description', $description, 15, 60));

	$options_tray = new XoopsFormElementTray(_AM_PDD_TEXTOPTIONS, '<br />');

	$html_checkbox = new XoopsFormCheckBox('', 'nohtml', $nohtml);
	$html_checkbox -> addOption(1, _AM_PDD_DISABLEHTML);
	$options_tray -> addElement($html_checkbox);

	$smiley_checkbox = new XoopsFormCheckBox('', 'nosmiley', $nosmiley);
	$smiley_checkbox -> addOption(1, _AM_PDD_DISABLESMILEY);
	$options_tray -> addElement($smiley_checkbox);

	$xcodes_checkbox = new XoopsFormCheckBox('', 'noxcodes', $noxcodes);
	$xcodes_checkbox -> addOption(1, _AM_PDD_DISABLEXCODE);
	$options_tray -> addElement($xcodes_checkbox);

	$noimages_checkbox = new XoopsFormCheckBox('', 'noimages', $noimages);
	$noimages_checkbox -> addOption(1, _AM_PDD_DISABLEIMAGES);
	$options_tray -> addElement($noimages_checkbox);

	$breaks_checkbox = new XoopsFormCheckBox('', 'nobreak', $nobreak);
	$breaks_checkbox -> addOption(1, _AM_PDD_DISABLEBREAK);
	$options_tray -> addElement($breaks_checkbox);
	$sform -> addElement($options_tray);

	$sform -> addElement(new XoopsFormHidden('cid', $cid));

	$sform -> addElement(new XoopsFormHidden('spotlighttop', $cid));

	$button_tray = new XoopsFormElementTray('', '');
	$hidden = new XoopsFormHidden('op', 'save');
	$button_tray -> addElement($hidden);

	if (!$cid)
	{
		$butt_create = new XoopsFormButton('', '', _AM_PDD_BSAVE, 'submit');
		$butt_create -> setExtra('onclick="this.form.elements.op.value=\'addCat\'"');
		$button_tray -> addElement($butt_create);

		$butt_clear = new XoopsFormButton('', '', _AM_PDD_BRESET, 'reset');
		$button_tray -> addElement($butt_clear);

		$butt_cancel = new XoopsFormButton('', '', _AM_PDD_BCANCEL, 'button');
		$butt_cancel -> setExtra('onclick="history.go(-1)"');
		$button_tray -> addElement($butt_cancel);
	}
	else
	{
		$butt_create = new XoopsFormButton('', '', _AM_PDD_BMODIFY, 'submit');
		$butt_create -> setExtra('onclick="this.form.elements.op.value=\'addCat\'"');
		$button_tray -> addElement($butt_create);

		$butt_delete = new XoopsFormButton('', '', _AM_PDD_BDELETE, 'submit');
		$butt_delete -> setExtra('onclick="this.form.elements.op.value=\'delCat\'"');
		$button_tray -> addElement($butt_delete);

		$butt_cancel = new XoopsFormButton('', '', _AM_PDD_BCANCEL, 'button');
		$butt_cancel -> setExtra('onclick="history.go(-1)"');
		$button_tray -> addElement($butt_cancel);
	}
	$sform -> addElement($button_tray);
	$sform -> display();

	$result2 = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . "");
	list($numrows) = $xoopsDB -> fetchRow($result2);
}

if (!isset($_POST['op']))
$op = isset($_GET['op']) ? $_GET['op'] : 'main';
else
$op = isset($_POST['op']) ? $_POST['op'] : 'main';

switch ($op)
{
	case "move":
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}
	if (!isset($_POST['ok']))
	{
		if (!isset($_POST['cid']) || $_POST['cid'] == 0)
		redirect_header("index.php", 3, _AM_PDD_FILE_SELCAT);
		else
		$cid = $_POST['cid'];

		xoops_cp_header();
		PDd_adminmenu(2);
		include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
		$sform = new XoopsThemeForm(_AM_PDD_CCATEGORY_MOVE, "move", xoops_getenv('PHP_SELF'), "post", true);
		ob_start();
		$mytree -> makeMySelBox("title", "title", 0 , 1, "target");
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_BMODIFY, ob_get_contents()));
		ob_end_clean();
		$create_tray = new XoopsFormElementTray('', '');
		$create_tray -> addElement(new XoopsFormHidden('source', $cid));
		$create_tray -> addElement(new XoopsFormHidden('ok', 1));
		$create_tray -> addElement(new XoopsFormHidden('op', 'move'));
		$butt_save = new XoopsFormButton('', '', _AM_PDD_BMOVE, 'submit');
		$butt_save -> setExtra('onclick="this.form.elements.op.value=\'move\'"');
		$create_tray -> addElement($butt_save);
		$butt_cancel = new XoopsFormButton('', '', _AM_PDD_BCANCEL, 'submit');
		$butt_cancel -> setExtra('onclick="this.form.elements.op.value=\'cancel\'"');
		$create_tray -> addElement($butt_cancel);
		$sform -> addElement($create_tray);
		$sform -> display();
		xoops_cp_footer();
	}
	else
	{
		global $xoopsDB;

		$source = $_POST['source'];
		$target = $_POST['target'];
		if ($target == $source)
		redirect_header("category.php?op=move&ok=0&cid=$source", 5, _AM_PDD_CCATEGORY_MODIFY_FAILED);

		if (!$target)
		redirect_header("category.php?op=move&ok=0&cid=$source", 5, _AM_PDD_CCATEGORY_MODIFY_FAILEDT);

		$sql = "UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " set cid = " . $target . " WHERE cid =" . $source;
		$result = $xoopsDB -> queryF($sql);
		$error = _AM_PDD_DBERROR . ": <br /><br />" . $sql;
		if (!$result)
		trigger_error($error, E_USER_ERROR);

		redirect_header("category.php?op=default", 1, _AM_PDD_CCATEGORY_MODIFY_MOVED);
		exit();
	}
	break;

	case "addCat":

	global $xoopsDB, $myts, $_FILES, $xoopsModuleConfig;

	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	$groups = isset($_POST['groups']) ? $_POST['groups'] : array();
	$cid = (isset($_POST["cid"])) ? $_POST["cid"] : 0;
	$pid = (isset($_POST["pid"])) ? $_POST["pid"] : 0;
	$weight = (isset($_POST["weight"]) && $_POST["weight"] > 0) ? $_POST["weight"] : 0;
	$spotlighthis = (isset($_POST["lid"])) ? $_POST["lid"] : 0;
	$spotlighttop = ($_POST["spotlighttop"] == 1) ? 1 : 0;
	$title = $myts -> addslashes($_POST["title"]);
	$description = $myts -> addslashes($_POST["description"]);
	$imgurl = ($_POST["imgurl"] && $_POST["imgurl"] != "blank.png") ? $myts -> addslashes($_POST["imgurl"]) : "";

	$nohtml = isset($_POST['nohtml']);
	$nosmiley = isset($_POST['nosmiley']);
	$noxcodes = isset($_POST['noxcodes']);
	$noimages = isset($_POST['noimages']);
	$nobreak = isset($_POST['nobreak']);

	if (!$cid)
	{
		$sql = "INSERT INTO " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . "
				(cid, pid, title, imgurl, description, nohtml, nosmiley,
				noxcodes, noimages, nobreak, weight, spotlighttop, spotlighthis) VALUES
				('', $pid, '$title', '$imgurl', '$description', '$nohtml', '$nosmiley',
				'$noxcodes', '$noimages', '$nobreak', '$weight',  $spotlighttop, $spotlighthis)";
		$result = $xoopsDB -> query($sql);
		$error = _AM_PDD_DBERROR . ": <br /><br />" . $sql;

		if ($cid == 0) $newid = $xoopsDB -> getInsertId();
		PDd_save_Permissions($groups, $newid, "PDDownCatPerm{$mydirnumber}");
		/**
             * Notify of new category
             */
		global $xoopsModule;
		$tags = array();
		$tags['CATEGORY_NAME'] = $title;
		$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $newid;
		$notification_handler = & xoops_gethandler('notification');
		$notification_handler -> triggerEvent('global', 0, 'new_category', $tags);
		$database_mess = _AM_PDD_CCATEGORY_CREATED;
	}
	else
	{
		$sql = "UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " SET
				title ='$title', imgurl = '$imgurl', pid =$pid, description = '$description',
				spotlighthis = '$spotlighthis' , spotlighttop = '$spotlighttop', nohtml='$nohtml', nosmiley='$nosmiley',
				noxcodes='$noxcodes', noimages='$noimages', nobreak='$nobreak', weight='$weight' WHERE cid = '$cid'";
		$result = $xoopsDB -> query($sql);
		$error = _AM_PDD_DBERROR . ": <br /><br />" . $sql;
		$database_mess = _AM_PDD_CCATEGORY_MODIFIED;
		PDd_save_Permissions($groups, $cid, "PDDownCatPerm{$mydirnumber}");
	}
	if (!$result)
	trigger_error($error, E_USER_ERROR);

	redirect_header("category.php", 1, $database_mess);
	break;

	case "del":

	global $xoopsDB, $xoopsModule;

	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	if (!isset($_POST['cid']) || $_POST['cid'] == 0)
	redirect_header("index.php", 3, _AM_PDD_FILE_SELCAT);
	else
	$cid = $_POST['cid'];

	$ok = (isset($_POST['ok']) && $_POST['ok'] == 1) ? intval($_POST['ok']) : 0;

	if ($ok == 1)
	{
		// get all subcategories under the specified category
		$arr = $mytree -> getAllChildId($cid);
		$lcount = count($arr);
		$modid = getInfosfromModule($mydirname, "mid");

		for ($i = 0; $i < $lcount; $i++)
		{
			// get all downloads in each subcategory
			$result = $xoopsDB -> query("SELECT lid FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE cid=" . $arr[$i] . "");
			// now for each download, delete the text data and vote ata associated with the download
			while (list($lid) = $xoopsDB -> fetchRow($result))
			{
				$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " where lid = $lid");
				$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " where lid = $lid");
				// delete comments
				xoops_groupperm_deletebymoditem ($modid, "PDDownFilePerm{$mydirnumber}", $lid);
				xoops_notification_deletebyitem ($modid, "file", $lid);
				xoops_comment_delete($modid, $lid);
			}
			// all downloads for each subcategory is deleted, now delete the subcategory data
			$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " where cid = ".$arr[$i]."");
			xoops_notification_deletebyitem ($modid, "category", $arr[$i]);
			xoops_groupperm_deletebymoditem ($modid, "PDDownCatPerm{$mydirnumber}", $arr[$i]);
		}
		// all subcategory and associated data are deleted, now delete category data and its associated data
		$result = $xoopsDB -> query("SELECT lid FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE cid= $cid");
		while (list($lid) = $xoopsDB -> fetchRow($result))
		{
			$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " where lid = $lid");
			$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " where lid = $lid");
			// delete comments
			xoops_groupperm_deletebymoditem ($modid, "PDDownFilePerm{$mydirnumber}", $lid);
			xoops_notification_deletebyitem ($modid, "file", $lid);
			xoops_comment_delete($modid, $lid);
		}
		$xoopsDB -> queryF("delete from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " where cid = $cid");
		xoops_notification_deletebyitem ($modid, "category", $cid);
		xoops_groupperm_deletebymoditem ($modid, "PDDownCatPerm{$mydirnumber}", $cid);

		redirect_header("category.php", 1, _AM_PDD_CCATEGORY_DELETED);
		exit();
	}
	else
	{
		xoops_cp_header();
		xoops_confirm(array('op' => 'del', 'cid' => $cid, 'ok' => 1), 'category.php', _AM_PDD_CCATEGORY_AREUSURE);
		xoops_cp_footer();
	}
	break;

	case "modCat":
	if (!isset($_POST['cid']) || $_POST['cid'] == 0)
	redirect_header("index.php", 3, _AM_PDD_FILE_SELCAT);
	else
	$cid = $_POST['cid'];

	xoops_cp_header();
	PDd_adminmenu(2);
	createcat($cid);
	xoops_cp_footer();
	break;

	case 'main':
	default:

	xoops_cp_header();
	PDd_adminmenu(2);

	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
	$mytree = new XoopsTree($xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat"), "cid", "pid");
	$sform = new XoopsThemeForm(_AM_PDD_CCATEGORY_MODIFY, "category", xoops_getenv('PHP_SELF'), "post", true);
	$totalcats = PDd_totalcategory();

	if ($totalcats > 0)
	{
		ob_start();
		$mytree -> makeMySelBox("title", "title", 0, 1);
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_CCATEGORY_MODIFY_TITLE, ob_get_contents()));
		ob_end_clean();
		$dup_tray = new XoopsFormElementTray('', '');
		$dup_tray -> addElement(new XoopsFormHidden('op', 'modCat'));
		$butt_dup = new XoopsFormButton('', '', _AM_PDD_BMODIFY, 'submit');
		$butt_dup -> setExtra('onclick="this.form.elements.op.value=\'modCat\'"');
		$dup_tray -> addElement($butt_dup);
		$butt_move = new XoopsFormButton('', '', _AM_PDD_BMOVE, 'submit');
		$butt_move -> setExtra('onclick="this.form.elements.op.value=\'move\'"');
		$dup_tray -> addElement($butt_move);
		$butt_dupct = new XoopsFormButton('', '', _AM_PDD_BDELETE, 'submit');
		$butt_dupct -> setExtra('onclick="this.form.elements.op.value=\'del\'"');
		$dup_tray -> addElement($butt_dupct);
		$sform -> addElement($dup_tray);
		$sform -> display();
	}
	createcat(0);
	xoops_cp_footer();
	break;
}

?>