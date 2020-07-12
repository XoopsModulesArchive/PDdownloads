<?php
/**
 * $Id: index.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
include_once "../class/PDd_lists.php";

function Download()
{
	global $xoopsDB, $_GET, $_POST, $myts, $mytree, $xoopsModuleConfig, $xoopsModule;
	if (empty($mydirname)){
		include '../include/mydirname.php';
	}

	$lid = 0;
	$cid = 0;
	$title = '';
	$url = 'http://';
	$homepage = 'http://';
	$homepagetitle = '';
	$version = '';
	$size = 0;
	$platform = '';
	$screenshot = '';
	$description = '';
	$features = '';
	$forumid = 0;
	$dhistory = '';
	$status = 0;
	$is_updated = 0;
	$offline = 0;
	$published = 0;
	$expired = 0;
	$updated = 0;
	$versiontypes = '';
	$publisher = '';
	$ipaddress = '';
	$notifypub = '';

	if (isset($_POST['lid']))
	{
		$lid = $_POST['lid'];
	} elseif (isset($_GET['lid']))
	{
		$lid = $_GET['lid'];
	}
	else
	{
		$lid = 0;
	}
	$directory = $xoopsModuleConfig['screenshots'];

	$result = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . "");
	list($numrows) = $xoopsDB -> fetchRow($result);

	$down_array = '';

	if ($numrows)
	{
		xoops_cp_header();

		PDd_adminmenu(3);

		echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_FILE_ALLOWEDAMIME . "</legend>\n
		<div style='padding: 8px;'>\n";
		$query = "select mime_ext from " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_mimetypes") . " WHERE mime_admin = 1 ORDER by mime_ext";
		$result = $xoopsDB -> query($query);
		$allowmimetypes = '';
		while ($mime_arr = $xoopsDB -> fetchArray($result))
		{
			echo $mime_arr['mime_ext'] . " | ";
		}
		echo "</div>\n
		</fieldset><br />\n
		";

		if ($lid)
		{
			$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=" . $lid . "";
			$down_array = $xoopsDB -> fetchArray($xoopsDB -> query($sql));

			$lid = $down_array['lid'];
			$cid = $down_array['cid'];
			$title = $myts -> htmlSpecialChars($down_array['title']);
			$url = $myts -> htmlSpecialChars($down_array['url']);
			$homepage = $myts -> htmlSpecialChars($down_array['homepage']);
			$homepagetitle = $myts -> htmlSpecialChars($down_array['homepagetitle']);
			$version = $down_array['version'];
			$size = intval($down_array['size']/1024);
			$platform = $myts -> htmlSpecialChars($down_array['platform']);
			$publisher = $myts -> htmlSpecialChars($down_array['publisher']);
			$screenshot = $myts -> htmlSpecialChars($down_array['screenshot']);
			$description = $myts -> htmlSpecialChars($down_array['description']);
			$features = $myts -> htmlSpecialChars($down_array['features']);
			$dhistory = $myts -> htmlSpecialChars($down_array['dhistory']);
			$published = $down_array['published'];
			$expired = $down_array['expired'];
			$updated = $down_array['updated'];
			$offline = $down_array['offline'];
			$forumid = $down_array['forumid'];
			$ipaddress = $down_array['ipaddress'];
			$notifypub = $down_array['notifypub'];
			$sform = new XoopsThemeForm(_AM_PDD_FILE_MODIFYFILE, "storyform", xoops_getenv('PHP_SELF'), "post", true);
		}
		else
		{
			$sform = new XoopsThemeForm(_AM_PDD_FILE_CREATENEPDILE, "storyform", xoops_getenv('PHP_SELF'), "post", true);
		}

		$sform -> setExtra('enctype="multipart/form-data"');
		if ($lid) $sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_ID, $lid));
		if ($ipaddress) $sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_IP, $ipaddress));
		$member_handler = & xoops_gethandler('member');
		$group_list = & $member_handler -> getGroupList();

		$gperm_handler = & xoops_gethandler('groupperm');
		$groups = $gperm_handler -> getGroupIds("PDDownFilePerm{$mydirnumber}", $lid, $xoopsModule -> getVar('mid'));

		$groups = ($groups) ? $groups : true;
		$sform -> addElement(new XoopsFormSelectGroup(_AM_PDD_FILE_GROUPPROMPT, "groups", true, $groups, 5, true));

		$titles_tray = new XoopsFormElementTray(_AM_PDD_FILE_TITLE, '<br />');
		$titles = new XoopsFormText('', 'title', 50, 255, $title);
		$titles_tray -> addElement($titles);
		$titles_checkbox = new XoopsFormCheckBox('', "title_checkbox", 0);
		$titles_checkbox -> addOption(1, _AM_PDD_FILE_USE_UPLOAD_TITLE);
		$titles_tray -> addElement($titles_checkbox);
		$sform -> addElement($titles_tray);

		$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_DLURL, 'url', 50, 255, $url), true);
		$sform -> addElement(new XoopsFormFile(""._AM_PDD_FILE_DUPLOAD." <span style='font-weight: normal;'>"._AM_PDD_FILE_DUPLOADSIZE."".PDd_PrettySize(intval($xoopsModuleConfig['maxfilesize'])*1024)."</span>", 'userfile', 0));
		ob_start();
		$mytree -> makeMySelBox('title', 'title', $cid, 1);
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_CATEGORY, ob_get_contents()), true);
		ob_end_clean();

		$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_HOMEPAGETITLE, 'homepagetitle', 50, 255, $homepagetitle), false);
		$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_HOMEPAGE, 'homepage', 50, 255, $homepage), false);
		$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_VERSION, 'version', 10, 20, $version), false);
		$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_SIZE, 'size', 10, 20, $size), false);

		$platform_array = $xoopsModuleConfig['platform'];
		$platform_select = new XoopsFormSelect('', 'platform', $platform, '', '', 0);
		$platform_select -> addOptionArray($platform_array);
		$platform_tray = new XoopsFormElementTray(_AM_PDD_FILE_PLATFORM, '&nbsp;');
		$platform_tray -> addElement($platform_select);
		$sform -> addElement($platform_tray);

		$sform -> addElement(new XoopsFormDhtmlTextArea(_AM_PDD_FILE_DESCRIPTION, 'description', $description, 15, 60), true);
		$sform -> addElement(new XoopsFormTextArea(_AM_PDD_FILE_KEYFEATURES, 'features', $features, 7, 60), false);
		$sform -> addElement(new XoopsFormTextArea(_AM_PDD_FILE_HISTORY, 'dhistory', $dhistory, 7, 60), false);
		if ($lid && !empty($dhistory))
		$sform -> addElement(new XoopsFormTextArea(_AM_PDD_FILE_HISTORYD, 'dhistoryaddedd', "", 7, 60), false);
		$graph_array = & PDsLists :: getListTypeAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['screenshots'], $type = "images");
		$indeximage_select = new XoopsFormSelect('', 'screenshot', $screenshot);
		$indeximage_select -> addOptionArray($graph_array);
		$indeximage_select -> setExtra("onchange='showImgSelected(\"image\", \"screenshot\", \"" . $xoopsModuleConfig['screenshots'] . "\", \"\", \"" . XOOPS_URL . "\")'");
		$indeximage_tray = new XoopsFormElementTray(_AM_PDD_FILE_SHOTIMAGE, '&nbsp;');
		$indeximage_tray -> addElement($indeximage_select);
		if (!empty($imgurl))
		$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['screenshots'] . "/" . $screenshot . "' name='image' id='image' alt='' />"));
		else
		$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />"));
		$sform -> addElement($indeximage_tray);

		$sform -> insertBreak(sprintf(_AM_PDD_FILE_MUSTBEVALID, "<b>" . $directory . "</b>"), "even");
		ob_start();
		PDd_getforum($forumid);
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_DISCUSSINFORUM, ob_get_contents()));
		ob_end_clean();

		$publishtext = (!$lid && !$published) ? _AM_PDD_FILE_SETPUBLISHDATE : _AM_PDD_FILE_SETNEWPUBLISHDATE;
		if ($published > time())
		$publishtext = _AM_PDD_FILE_SETPUBDATESETS;
		$ispublished = ($published > time()) ? 1 : 0 ;
		$publishdates = ($published > time()) ? _AM_PDD_FILE_PUBLISHDATESET . formatTimestamp($published, "Y-m-d H:s") : _AM_PDD_FILE_SETDATETIMEPUBLISH;
		$publishdate_checkbox = new XoopsFormCheckBox('', 'publishdateactivate', $ispublished);
		$publishdate_checkbox -> addOption(1, $publishdates . "<br /><br />");

		$publishdate_tray = new XoopsFormElementTray(_AM_PDD_FILE_PUBLISHDATE, '');
		$publishdate_tray -> addElement($publishdate_checkbox);
		$publishdate_tray -> addElement(new XoopsFormDateTime($publishtext, 'published', 15, $published));
		$publishdate_tray -> addElement(new XoopsFormRadioYN(_AM_PDD_FILE_CLEARPUBLISHDATE, 'clearpublish', 0, ' ' . _YES . '', ' ' . _NO . ''));
		$sform -> addElement($publishdate_tray);

		$isexpired = ($expired > time()) ? 1: 0 ;
		$expiredates = ($expired > time()) ? _AM_PDD_FILE_EXPIREDATESET . formatTimestamp($expired, 'Y-m-d H:s') : _AM_PDD_FILE_SETDATETIMEEXPIRE;
		$warning = ($published > $expired && $expired > time()) ? _AM_PDD_FILE_EXPIREWARNING : '';
		$expiredate_checkbox = new XoopsFormCheckBox('', 'expiredateactivate', $isexpired);
		$expiredate_checkbox -> addOption(1, $expiredates . "<br /><br />");

		$expiredate_tray = new XoopsFormElementTray(_AM_PDD_FILE_EXPIREDATE . $warning, '');
		$expiredate_tray -> addElement($expiredate_checkbox);
		$expiredate_tray -> addElement(new XoopsFormDateTime(_AM_PDD_FILE_SETEXPIREDATE . "<br />", 'expired', 15, $expired));
		$expiredate_tray -> addElement(new XoopsFormRadioYN(_AM_PDD_FILE_CLEAREXPIREDATE, 'clearexpire', 0, ' ' . _YES . '', ' ' . _NO . ''));
		$sform -> addElement($expiredate_tray);

		$filestatus_radio = new XoopsFormRadioYN(_AM_PDD_FILE_FILESSTATUS, 'offline', $offline, ' ' . _YES . '', ' ' . _NO . '');
		$sform -> addElement($filestatus_radio);

		if ($lid)
		{
			$up_dated = ($updated == 0) ? 0 : 1;
			$file_updated_radio = new XoopsFormRadioYN(_AM_PDD_FILE_SETASUPDATED, 'up_dated', $up_dated, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($file_updated_radio);
			$file_resetcalls_radio = new XoopsFormRadioYN(_AM_PDD_FILE_RESETCALLS, 'resetcalls', 0, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($file_resetcalls_radio);
			$sform -> addElement(new XoopsFormHidden('was_published', $published));
			$sform -> addElement(new XoopsFormHidden('was_expired', $expired));
		}

		//checkt ob die datei defekt ist und zeigt einen radiobutton an - Anfang
		$resultmess = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " WHERE lid=$lid");
		list ($countmess) = $xoopsDB->fetchRow($resultmess);
		if ($countmess > 0) {
			$editmess_radio = new XoopsFormRadioYN(_AM_PDD_FILE_DELEDITMESS, 'editmess', 0, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($editmess_radio);
		}
		//Ende

		include_once XOOPS_ROOT_PATH . '/class/xoopstopic.php';

		/* PDDOWNLOADS - START MOD BY BAERCHN extended by POWER-DREAMS --------------------------------------- */

		$i = 0;
		$newsmodule = array("news", "homenews", "altern8news");
		$newsheader = _AM_PDD_FILE_CREATENEWSSTORY;

		if (SearchModule($newsmodule[$i]))
		{
			//for original news modul
			$newsmoduleheader = getInfosfromModule($newsmodule[$i], "name");
			$sform -> insertBreak("$newsmoduleheader: $newsheader", "bg3");
			$submitNews_radio = new XoopsFormRadioYN(_AM_PDD_FILE_SUBMITNEWS, 'submitNews', 0, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($submitNews_radio);
			$xt = new XoopsTopic($xoopsDB -> prefix('topics'));
			ob_start();
			$xt -> makeTopicSelBox(1, 0, "newstopicid");
			$sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_NEWSCATEGORY, ob_get_contents()));
			ob_end_clean();
			$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_NEWSTITLE, 'newsTitle', 50, 255, ''), false);
		}
		$i++;

		if (SearchModule($newsmodule[$i]))
		{
			//for homenews modul
			$newsmoduleheader = getInfosfromModule($newsmodule[$i], "name");
			$sform -> insertBreak("$newsmoduleheader: $newsheader", "bg3");
			$submitNews1_radio = new XoopsFormRadioYN(_AM_PDD_FILE_SUBMITNEWS, 'submitNews1', 0, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($submitNews1_radio);
			$xt = new XoopsTopic($xoopsDB -> prefix('homethemen'));
			ob_start();
			$xt -> makeTopicSelBox(1, 0, "newstopicid");
			$sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_NEWSCATEGORY, ob_get_contents()));
			ob_end_clean();
			$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_NEWSTITLE, 'newsTitle', 50, 255, ''), false);
		}
		$i++;

		if (SearchModule($newsmodule[$i]))
		{
			//for altern8news modul
			$newsmoduleheader = getInfosfromModule($newsmodule[$i], "name");
			$sform -> insertBreak("$newsmoduleheader: $newsheader", "bg3");
			$submitNews2_radio = new XoopsFormRadioYN(_AM_PDD_FILE_SUBMITNEWS, 'submitNews2', 0, ' ' . _YES . '', ' ' . _NO . '');
			$sform -> addElement($submitNews2_radio);
			$xt = new XoopsTopic($xoopsDB -> prefix('beosthemen'));
			ob_start();
			$xt -> makeTopicSelBox(1, 0, "newstopicid");
			$sform -> addElement(new XoopsFormLabel(_AM_PDD_FILE_NEWSCATEGORY, ob_get_contents()));
			ob_end_clean();
			$sform -> addElement(new XoopsFormText(_AM_PDD_FILE_NEWSTITLE, 'newsTitle', 50, 255, ''), false);
		}

		unset ($newsmodule, $i, $newsheader, $newsmoduleheader);
		/* PDDOWNLOADS - END MOD BY BAERCHN extended by POWER-DREAMS --------------------------------------- */

		if ($lid && $published == 0)
		{
			$approved = ($published == 0) ? 0 : 1;
			$approve_checkbox = new XoopsFormCheckBox(_AM_PDD_FILE_EDITAPPROVE, "approved", 1);
			$approve_checkbox -> addOption(1, " ");
			$sform -> addElement($approve_checkbox);
		}

		if (!$lid)
		{
			$button_tray = new XoopsFormElementTray('', '');
			$button_tray -> addElement(new XoopsFormHidden('status', 1));
			$button_tray -> addElement(new XoopsFormHidden('notifypub', $notifypub));
			$button_tray -> addElement(new XoopsFormHidden('op', 'addDownload'));
			$button_tray -> addElement(new XoopsFormButton('', '', _AM_PDD_BSAVE, 'submit'));
			$sform -> addElement($button_tray);
		}
		else
		{
			$button_tray = new XoopsFormElementTray('', '');
			$button_tray -> addElement(new XoopsFormHidden('lid', $lid));
			$button_tray -> addElement(new XoopsFormHidden('status', 2));
			$hidden = new XoopsFormHidden('op', 'addDownload');
			$button_tray -> addElement($hidden);

			$butt_dup = new XoopsFormButton('', '', _AM_PDD_BMODIFY, 'submit');
			$butt_dup -> setExtra('onclick="this.form.elements.op.value=\'addDownload\'"');
			$button_tray -> addElement($butt_dup);

			$butt_dupct = new XoopsFormButton('', '', _AM_PDD_BDELETE, 'submit');
			$butt_dupct -> setExtra('onclick="this.form.elements.op.value=\'delDownload\'"');
			$button_tray -> addElement($butt_dupct);

			$butt_dupct2 = new XoopsFormButton('', '', _AM_PDD_BCANCEL, 'submit');
			$butt_dupct2 -> setExtra('onclick="this.form.elements.op.value=\'downloadsConfigMenu\'"');
			$button_tray -> addElement($butt_dupct2);
			$sform -> addElement($button_tray);
		}
		$sform -> display();
		unset($hidden);
	}
	else
	{
		redirect_header("category.php?", 1, _AM_PDD_CCATEGORY_NOEXISTS);
		exit();
	}

	if ($lid)
	{
		global $imagearray;
		// Vote data
		$result01 = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " ");
		list($totalvotes) = $xoopsDB -> fetchRow($result01);

		$result02 = $xoopsDB -> query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid = $lid AND ratinguser != 0 ORDER BY ratingtimestamp DESC");
		$votesreg = $xoopsDB -> getRowsNum($result02);
		$result03 = $xoopsDB -> query("SELECT ratingid, ratinguser, rating, ratinghostname, ratingtimestamp FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid = $lid AND ratinguser = 0 ORDER BY ratingtimestamp DESC");
		$votesanon = $xoopsDB -> getRowsNum($result03);

		echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_VOTE_RATINGINFOMATION . "</legend>\n
		<div style='padding: 8px;'><b>" . _AM_PDD_VOTE_TOTALVOTES . "</b>" . $totalvotes . "<br /><br />\n
		";

		printf(_AM_PDD_VOTE_REGUSERVOTES, $votesreg);

		echo "<br />";

		printf(_AM_PDD_VOTE_ANONUSERVOTES, $votesanon);

		echo "
		</div>\n
		<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>\n
		<th align='center'>" . _AM_PDD_VOTE_USER . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_IP . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_RATING . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_USERAVG . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_TOTALRATE . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_DATE . "</td>\n
		<th align='center'>" . _AM_PDD_MINDEX_ACTION . "</td>\n
		</tr>\n
		";

		if ($votesreg == 0)
		{
			echo "<tr><td align='center' colspan='7' class='even'><b>" . _AM_PDD_VOTE_NOREGVOTES . "</b></td></tr>";
		}
		while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB -> fetchRow($result02))
		{
			$result04 = $xoopsDB -> query("SELECT rating FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE ratinguser = $ratinguser");
			$uservotes = $xoopsDB -> getRowsNum($result04);
			$formatted_date = formatTimestamp($ratingtimestamp, $xoopsModuleConfig['dateformat']);
			$useravgrating = 0;
			while (list($rating2) = $xoopsDB -> fetchRow($result04))
			{
				$useravgrating = $useravgrating + $rating2;
			}
			$useravgrating = $useravgrating / $uservotes;
			$useravgrating = number_format($useravgrating, 1);
			$ratinguname = XoopsUser :: getUnameFromId($ratinguser);

			echo "
		<tr><td align='center' class='head'>$ratinguname</td>\n
		<td align='center' class='even'>$ratinghostname</th>\n
		<td align='center' class='even'>$rating</th>\n
		<td align='center' class='even'>$useravgrating</th>\n
		<td align='center' class='even'>$uservotes</th>\n
		<td align='center' class='even'>$formatted_date</th>\n
		<td align='center' class='even'>\n
		<a href='index.php?op=delVote&lid=" . $lid . "&rid=" . $ratingid . "'>" . $imagearray['deleteimg'] ."</a>\n
		</th></tr>\n
		";
		}
		echo "
		</table>\n
		<br />\n
		<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>\n
		<th align='center'>" . _AM_PDD_VOTE_USER . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_IP . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_RATING . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_USERAVG . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_TOTALRATE . "</td>\n
		<th align='center'>" . _AM_PDD_VOTE_DATE . "</td>\n
		<th align='center'>" . _AM_PDD_MINDEX_ACTION . "</td>\n
		</tr>\n
		";
		if ($votesanon == 0)
		{
			echo "<tr><td colspan='7' align='center' class='even'><b>" . _AM_PDD_VOTE_NOUNREGVOTES . "</b></td></tr>";
		}
		while (list($ratingid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB -> fetchRow($result03))
		{
			$result05 = $xoopsDB -> query("SELECT rating FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE ratinguser = $ratinguser");
			$uservotes = $xoopsDB -> getRowsNum($result05);
			$formatted_date = formatTimestamp($ratingtimestamp, $xoopsModuleConfig['dateformat']);
			$useravgrating = 0;
			while (list($rating2) = $xoopsDB -> fetchRow($result04))
			{
				$useravgrating = $useravgrating + $rating2;
			}
			$useravgrating = $useravgrating / $uservotes;
			$useravgrating = number_format($useravgrating, 1);
			$ratinguname = XoopsUser :: getUnameFromId($ratinguser);

			echo "
		<tr><td align='center' class='head'>$ratinguname</td>\n
		<td align='center' class='even'>$ratinghostname</th>\n
		<td align='center' class='even'>$rating</th>\n
		<td align='center' class='even'>$useravgrating</th>\n
		<td align='center' class='even'>$uservotes</th>\n
		<td align='center' class='even'>$formatted_date</th>\n
		<td align='center' class='even'>\n
		<a href='index.php?op=delVote&lid=" . $lid . "&rid=" . $ratingid . "'>" . $imagearray['deleteimg'] . "</a>\n
		</th></tr>\n
		";
		}
		echo "
		</table>\n
		</fieldset>\n
		";
	}
	xoops_cp_footer();
}

function delVote()
{
	global $xoopsDB, $_GET;
	if (empty($mydirname))
	include '../include/mydirname.php';

	$xoopsDB -> queryF("DELETE FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE ratingid = " . $_GET['rid'] . "");
	PDd_updaterating($_GET['lid']);
	redirect_header("index.php", 1, _AM_PDD_VOTE_VOTEDELETED);
}

function addDownload()
{
	global $xoopsDB, $xoopsUser, $xoopsModule, $myts, $_FILES, $xoopsModuleConfig;
	if (empty($mydirname))
	include '../include/mydirname.php';

	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
	redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());

	$groups = isset($_POST['groups']) ? $_POST['groups'] : array();
	$lid = (!empty($_POST['lid'])) ? $_POST['lid'] : 0;

	if (!isset($_POST['cid']) || $_POST['cid'] == 0)
	redirect_header("index.php", 3, _AM_PDD_FILE_SELCAT);
	else
	$cid = $_POST['cid'];

	$status = (!empty($_POST['status'])) ? $_POST['status'] : 2;
	/**
     * Define URL
     */
	if (empty($_FILES['userfile']['name']) && $_POST["url"] && $_POST["url"] != "" && $_POST["url"] != "http://")
	{
		$url = ($_POST["url"] != "http://") ? $myts -> addslashes($_POST["url"]) : '';
		$size = ((empty($size) || !is_numeric($size))) ? $myts -> addslashes($_POST["size"]*1024) : 0;
		$title = $myts -> addslashes(trim($_POST["title"]));
	}
	else
	{
		global $_FILES;
		$down = PDd_uploading($_FILES, $xoopsModuleConfig['uploaddir'], "", "index.php", 0, 0);
		$url = $myts -> addslashes ($down['url']);
		$size = $down['size'];
		$title = $_FILES['userfile']['name'];
		$ext = rtrim(strrchr($title, '.'), '.');
		$title = str_replace($ext, '', $title);
		$title = (isset($_POST["title_checkbox"]) && $_POST["title_checkbox"] == 1) ? $title : $myts -> addslashes(trim($_POST["title"]));
	}
	/**
     * Get data from form
     */
	$screenshot = ($_POST["screenshot"] != "blank.png") ? $myts -> addslashes($_POST["screenshot"]) : '';

	$homepage = '';
	$homepagetitle = '';

	if (!empty($_POST["homepage"]) || $_POST["homepage"] != "http://")
	{
		$homepage = $myts -> addslashes(trim($_POST["homepage"]));
		$homepagetitle = $myts -> addslashes(trim($_POST["homepagetitle"]));
	}

	$version = (!empty($_POST["version"])) ? $myts -> addslashes(trim($_POST["version"])) : 0;
	$platform = $myts -> addslashes(trim($_POST["platform"]));
	$description = $myts -> addslashes(trim($_POST["description"]));
	$submitter = $xoopsUser -> uid();
	$publisher = $xoopsUser -> uname();
	$features = $myts -> addslashes(trim($_POST["features"]));
	$forumid = (isset($_POST["forumid"]) && $_POST["forumid"] > 0) ? intval($_POST["forumid"]) : 0;
	$dhistory = (isset($_POST["dhistory"])) ? $myts -> addslashes($_POST["dhistory"]) : '';
	$dhistoryhistory = (isset($_POST["dhistoryaddedd"])) ? $myts -> addslashes($_POST["dhistoryaddedd"]) : '';
	if ($lid > 0 && !empty($dhistoryhistory))
	{
		$dhistory = $dhistory . "\n\n";
		$time = time();
		$dhistory .= _AM_PDD_FILE_HISTORYVERS . $version . _AM_PDD_FILE_HISTORDATE . formatTimestamp($time, $xoopsModuleConfig['dateformat']) . "\n\n";
		$dhistory .= $dhistoryhistory;
	}
	$updated = (isset($_POST['was_published']) && $_POST['was_published'] == 0) ? 0 : time();

	if (!isset($_POST['up_dated']) || $_POST['up_dated'] == 0)
	{
		$updated = 0;
		$status = 1;
	}

	$offline = ($_POST['offline'] == 1) ? 1 : 0;
	$approved = (isset($_POST['approved']) && $_POST['approved'] == 1) ? 1 : 0;
	$notifypub = (isset($_POST['notifypub']) && $_POST['notifypub'] == 1);

	if (!$lid)
	{
		$date = time();
		$publishdate = time();
	}
	else
	{
		$publishdate = $_POST['was_published'];
		$expiredate = $_POST['was_expired'];
	}

	if ($approved == 1 && empty($publishdate))
	$publishdate = time();

	if (isset($_POST['resetcalls']) && $_POST['resetcalls'] == 1)
	$xoopsDB -> query("UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " SET hits = 0 WHERE lid=$lid");

	if (isset($_POST['publishdateactivate']))
	$publishdate = strtotime($_POST['published']['date']) + $_POST['published']['time'];

	if ($_POST['clearpublish'])
	{
		$result = $xoopsDB -> query("SELECT date FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=$lid");
		list($date) = $xoopsDB -> fetchRow($result);
		$publishdate = $date;
	}

	if (isset($_POST['expiredateactivate']))
	$expiredate = strtotime($_POST['expired']['date']) + $_POST['expired']['time'];

	if ($_POST['clearexpire'])
	$expiredate = '0';

	/**
     * Update or insert download data into database
     */
	if (!$lid)
	{
		$date = time();
		$publishdate = time();
		$ipaddress = $_SERVER['REMOTE_ADDR'];

		$query = "INSERT INTO " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
			(lid, cid, title, url, homepage, version, size, platform, screenshot, submitter, publisher, status,
			date, hits, rating, votes, comments, features, homepagetitle, forumid, dhistory, published, expired, updated, offline, description, ipaddress, notifypub)";
		$query .= " VALUES 	('', $cid, '$title', '$url', '$homepage', '$version', $size, '$platform', '$screenshot',
			'$submitter', '$publisher','$status', '$date', 0, 0, 0, 0, '$features', '$homepagetitle', '$forumid', '$dhistory', '$publishdate',
			0, '$updated', '$offline', '$description', '$ipaddress', '0')";
		$result = $xoopsDB -> queryF($query);
		$error = "Information not saved to database: <br /><br />";
		$error .= $query;
		if (!$result)
		{
			trigger_error($error, E_USER_ERROR);
		}
		$newid = $xoopsDB -> getInsertId();
		PDd_save_Permissions($groups, $newid, "PDDownFilePerm{$mydirnumber}");
	}
	else
	{
		if ($updated>0){$publishdate=time();}
		$xoopsDB -> query("UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " SET cid = $cid, title = '$title',
			url = '$url', features = '$features', homepage = '$homepage', version = '$version', size = $size, platform = '$platform',
			screenshot = '$screenshot', publisher = '$publisher', status = '$status', homepagetitle = '$homepagetitle', forumid = '$forumid', dhistory = '$dhistory', published = '$publishdate',
			expired = '$expiredate', updated = '$updated', offline = '$offline', description = '$description' WHERE lid = $lid");

		PDd_save_Permissions($groups, $lid, "PDDownFilePerm{$mydirnumber}");
	}
	/**
     * Send notifications
     */
	if (!$lid)
	{
		$tags = array();
		$tags['FILE_NAME'] = $title;
		$tags['FILE_URL'] = XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . "&amp;lid=" . $newid;
		$sql = "SELECT title FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $cid;
		$result = $xoopsDB -> query($sql);
		$row = $xoopsDB -> fetchArray($xoopsDB -> query($sql));
		$tags['CATEGORY_NAME'] = $row['title'];
		$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $cid;
		$notification_handler = & xoops_gethandler('notification');
		$notification_handler -> triggerEvent('global', 0, 'new_file', $tags);
		$notification_handler -> triggerEvent('category', $cid, 'new_file', $tags);
	}
	if ($lid && $approved)
	{
		$tags = array();
		$tags['FILE_NAME'] = $title;
		$tags['FILE_URL'] = XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . "&amp;lid=" . $lid;
		$sql = "SELECT title FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $cid;
		$result = $xoopsDB -> query($sql);
		$row = $xoopsDB -> fetchArray($result);
		$tags['CATEGORY_NAME'] = $row['title'];
		$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $cid;
		$notification_handler = & xoops_gethandler('notification');
		$notification_handler -> triggerEvent('global', 0, 'new_file', $tags);
		$notification_handler -> triggerEvent('category', $cid, 'new_file', $tags);
		if ($notifypub)
		$notification_handler -> triggerEvent('file', $lid, 'approve', $tags);
	}
	$message = (!$lid) ? _AM_PDD_FILE_NEPDILEUPLOAD : _AM_PDD_FILE_FILEMODIFIEDUPDATE ;
	$message = ($lid && !$_POST['was_published'] && $approved) ? _AM_PDD_FILE_FILEAPPROVED : $message;

	/* PDDOWNLOADS - START MOD BY POWER-DREAMS --------------------------------------- */

	if (!empty($_POST["editmess"]) && $_POST['editmess'] == 1)
	{
		$xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " WHERE lid = '$lid'");
	}

	$submitNews = !empty($_POST["submitNews"]) && $_POST['submitNews'] == 1;
	$submitNews1 = !empty($_POST["submitNews1"]) && $_POST['submitNews1'] == 1;
	$submitNews2 = !empty($_POST["submitNews2"]) && $_POST['submitNews2'] == 1;

	if ($submitNews && $submitNews1 && $submitNews2 || $submitNews && $submitNews1 || $submitNews && $submitNews2 || $submitNews1 && $submitNews2)
	{
		redirect_header("index.php", 3, _AM_PDD_ONETHING);
		exit();
	}

	if ($submitNews)
	$newsmodule = "news";
	if ($submitNews1)
	$newsmodule = "homenews";
	if ($submitNews2)
	$newsmodule = "altern8news";

	if (!empty($newsmodule))
	include_once "newstory.php";

	/* PDDOWNLOADS - END MOD BY POWER-DREAMS --------------------------------------- */

	redirect_header("index.php", 1, $message);
}

// Page start here
if (isset($_POST))
{
	foreach ($_POST as $k => $v)
	{
		$$k = $v;
	}
}

if (isset($_GET))
{
	foreach ($_GET as $k => $v)
	{
		$$k = $v;
	}
}

if (!isset($_POST['op']))
{
	$op = isset($_GET['op']) ? $_GET['op'] : 'main';
}
else
{
	$op = $_POST['op'];
}

switch ($op)
{
	case "addDownload":
	addDownload();
	break;

	case "Download":
	Download();
	break;

	case "delDownload":

	global $xoopsDB, $_POST, $xoopsModule, $xoopsModuleConfig;

	$confirm = (isset($confirm)) ? 1 : 0;
	if ($confirm)
	{
		if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());

		$file = XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['uploaddir'] . "/" . basename($_POST['url']);
		if (is_file($file))
		@unlink($file);

		$lid = (isset($_POST['lid']) && $_POST['lid']) ? intval($_POST['lid']) : 0;
		$modid = getInfosfromModule($mydirname, "mid");

		$xoopsDB -> query("DELETE FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $lid");
		$xoopsDB -> query("DELETE FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid = $lid");
		xoops_groupperm_deletebymoditem ($modid, "PDDownFilePerm{$mydirnumber}", $lid);
		xoops_notification_deletebyitem ($modid, "file", $lid);
		// delete comments
		xoops_comment_delete($modid, $lid);
		redirect_header("index.php", 1, sprintf(_AM_PDD_FILE_FILEWASDELETED, $title));
		exit();
	}
	else
	{
		$lid = (isset($_POST['lid'])) ? $_POST['lid'] : $lid;
		$result = $xoopsDB -> query("SELECT lid, title, url FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $lid");
		list($lid, $title, $url) = $xoopsDB -> fetchrow($result);
		xoops_cp_header();
		xoops_confirm(array('op' => 'delDownload', 'lid' => $lid, 'confirm' => 1, 'title' => $title, 'url' => $url), 'index.php', _AM_PDD_FILE_REALLYDELETEDTHIS . "<br /><br>" . $title, _DELETE, true);
		xoops_cp_footer();
	}
	break;
	case "delVote":
	delVote();

	break;
	case "createdir":
	if (isset($_GET['path'])) $path = $_GET['path'];
	$res = PDd_mkdir($path);
	$msg = ($res)?_MD_PDD_DIRCREATED:_MD_PDD_DIRNOTCREATED;
	redirect_header('index.php', 2, $msg . ': ' . $path);
	exit();
	break;

	case "setperm":
	$res = PDd_chmod($path, 0777);
	$msg = ($res)?_MD_PDD_PERMSET:_MD_PDD_PERMNOTSET;
	redirect_header('index.php', 2, $msg . ': ' . $path);
	exit();
	break;

	case 'main':
	default:

	global $xoopsUser, $xoopsDB, $xoopsConfig;
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$start1 = isset($_GET['start1']) ? intval($_GET['start1']) : 0;
	$start2 = isset($_GET['start2']) ? intval($_GET['start2']) : 0;
	$start3 = isset($_GET['start3']) ? intval($_GET['start3']) : 0;
	$start4 = isset($_GET['start4']) ? intval($_GET['start4']) : 0;
	$start5 = isset($_GET['start5']) ? intval($_GET['start5']) : 0;
	$totalcats = PDd_totalcategory();
	$result = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_broken") . "");
	list($totalbrokendownloads) = $xoopsDB -> fetchRow($result);
	$result2 = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_mod") . "");
	list($totalmodrequests) = $xoopsDB -> fetchRow($result2);

	$result3 = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE published = 0");
	list($totalnewdownloads) = $xoopsDB -> fetchRow($result3);
	$result4 = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE published > 0");
	list($totaldownloads) = $xoopsDB -> fetchRow($result4);

	xoops_cp_header();
	PDd_adminmenu(0);

	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_MINDEX_DOWNSUMMARY . "</legend>\n
		<div style='padding: 8px;'><small>\n
		<a href='category.php'>" . _AM_PDD_SCATEGORY . "</a><b>" . $totalcats . "</b> | \n
		<a href='index.php?op=Download'>" . _AM_PDD_SFILES . "</a><b>" . $totaldownloads . "</b> | \n
		<a href='newdownloads.php'>" . _AM_PDD_SNEPDILESVAL . "</a><b>" . $totalnewdownloads . "</b> | \n
		<a href='modifications.php'>" . _AM_PDD_SMODREQUEST . "</a><b>" . $totalmodrequests . "</b> | \n
		<a href='brokendown.php'>" . _AM_PDD_SBROKENSUBMIT . "</a><b>" . $totalbrokendownloads . "</b> | \n
		</small></div></fieldset><br />\n";

	PDd_serverstats();

	echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _MD_PDD_UPLOADPATHINFO . "</legend>\n
	<div style='padding: 8px;'><small>\n" . sprintf(_MD_PDD_UPLOADPATH, _AM_PDD_UPLOADS) . ": ";
	$down_path = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['uploaddir'] . '/';
	$path_status1 = PDd_getPathStatus($down_path);
	echo $down_path . ' ( ' . $path_status1 . ' )';
	echo "<br>\n" . sprintf(_MD_PDD_UPLOADPATH, _AM_PDD_DOWN_CATIMAGE) . ": ";
	$image_path = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['mainimagedir'] . '/';
	$path_status2 = PDd_getPathStatus($image_path);
	echo $image_path . ' ( ' . $path_status2 . ' )';
	echo "<br>\n" . sprintf(_MD_PDD_UPLOADPATH, _AM_PDD_DOWN_SCREENSHOTS) . ": ";
	$screenshots_path = XOOPS_ROOT_PATH . '/' . $xoopsModuleConfig['screenshots'] . '/';
	$path_status3 = PDd_getPathStatus($screenshots_path);
	echo $screenshots_path . ' ( ' . $path_status3 . ' )';
	echo "</small></div></fieldset><br />\n";

	if ($totalcats > 0)
	{
		include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
		$sform = new XoopsThemeForm(_AM_PDD_CCATEGORY_MODIFY, "category", "category.php", "post", true);
		ob_start();
		$sform -> addElement(new XoopsFormHidden('cid', ''));
		$mytree -> makeMySelBox("title", "title",0,1);
		$sform -> addElement(new XoopsFormLabel(_AM_PDD_CCATEGORY_MODIFY_TITLE, ob_get_contents()));
		ob_end_clean();
		$dup_tray = new XoopsFormElementTray('', '');
		$dup_tray -> addElement(new XoopsFormHidden('op', 'modCat'));
		$butt_dup = new XoopsFormButton('', '', _AM_PDD_BMODIFY, 'submit');
		$butt_dup -> setExtra('onclick="this.form.elements.op.value=\'modCat\'"');
		$dup_tray -> addElement($butt_dup);
		$butt_dupct = new XoopsFormButton('', '', _AM_PDD_BDELETE, 'submit');
		$butt_dupct -> setExtra('onclick="this.form.elements.op.value=\'del\'"');
		$dup_tray -> addElement($butt_dupct);
		$sform -> addElement($dup_tray);
		$sform -> display();
	}

	if ($totaldownloads > 0)
	{
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
				WHERE published > 0 AND published <= " . time() . " AND (expired = 0 OR expired > " . time() . ")
				AND offline = 0 ORDER BY lid DESC" ;
		$published_array = $xoopsDB -> query($sql, $xoopsModuleConfig['admin_perpage'], $start);
		$published_array_count = $xoopsDB -> getRowsNum($xoopsDB -> query($sql));

		PDd_downlistheader(_AM_PDD_MINDEX_PUBLISHEDDOWN);
		if ($published_array_count > 0)
		{
			while ($published = $xoopsDB -> fetchArray($published_array))
			{
				PDd_downlistbody($published);
			}
		}
		else
		{
			PDd_downlistfooter();
		}
		PDd_downlistpagenav($published_array_count, $start, 'art');

		/**
             * Auto Publish
             */
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
				WHERE published > " . time() . " ORDER BY lid DESC" ;
		$auto_publish_array = $xoopsDB -> query($sql, $xoopsModuleConfig['admin_perpage'], $start2);
		$auto_publish_count = $xoopsDB -> getRowsNum($xoopsDB -> query($sql));
		PDd_downlistheader(_AM_PDD_MINDEX_AUTOPUBLISHEDDOWN);
		if ($auto_publish_count > 0)
		{
			while ($auto_publish = $xoopsDB -> fetchArray($auto_publish_array))
			{
				PDd_downlistbody($auto_publish);
			}
		}
		else
		{
			PDd_downlistfooter();
		}
		PDd_downlistpagenav($auto_publish_count, $start2, 'art2');

		/**
             * Auto expire
             */
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
				WHERE expired > " . time() . " ORDER BY lid DESC" ;
		$auto_expire_array = $xoopsDB -> query($sql, $xoopsModuleConfig['admin_perpage'], $start3);
		$auto_expire_count = $xoopsDB -> getRowsNum($xoopsDB -> query($sql));

		PDd_downlistheader(_AM_PDD_MINDEX_AUTOEXPIRE);
		if ($auto_expire_count > 0)
		{
			while ($auto_expire = $xoopsDB -> fetchArray($auto_expire_array))
			{
				PDd_downlistbody($auto_expire);
			}
		}
		else
		{
			PDd_downlistfooter();
		}
		PDd_downlistpagenav($auto_expire_count, $start3, 'art3');

		/**
             * Expired
             */
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
				WHERE expired < " . time() . " AND expired > 0 ORDER BY lid DESC" ;
		$expired_array = $xoopsDB -> query($sql, $xoopsModuleConfig['admin_perpage'], $start4);
		$expired_count = $xoopsDB -> getRowsNum($xoopsDB -> query($sql));

		PDd_downlistheader(_AM_PDD_MINDEX_EXPIRED);
		if ($expired_count > 0)
		{
			while ($expired = $xoopsDB -> fetchArray($expired_array))
			{
				PDd_downlistbody($expired);
			}
		}
		else
		{
			PDd_downlistfooter();
		}
		PDd_downlistpagenav($expired_count, $start4, 'art4');

		/**
             * Offline
             */
		$sql = "SELECT * FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE
				offline = 1 ORDER BY lid DESC" ;
		$offline_array = $xoopsDB -> query($sql, $xoopsModuleConfig['admin_perpage'], $start5);
		$offline_count = $xoopsDB -> getRowsNum($xoopsDB -> query($sql));

		PDd_downlistheader(_AM_PDD_MINDEX_OFFLINEDOWN);
		if ($offline_count > 0)
		{
			while ($is_offline = $xoopsDB -> fetchArray($offline_array))
			{
				PDd_downlistbody($is_offline);
			}
		}
		else
		{
			PDd_downlistfooter();
		}
		PDd_downlistpagenav($offline_count, $start5, 'art5');
	}
	xoops_cp_footer();
	break;
}

?>
