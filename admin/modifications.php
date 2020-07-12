<?php 
/**
 * $Id: modifications.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';

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
	case "listModReqshow":

	include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

	global $xoopsDB, $myts, $mytree, $xoopsModuleConfig, $xoopsUser;

	xoops_cp_header();
	PDd_adminmenu();

	$requestid = intval($_GET['requestid']);

	$sql = "SELECT modifysubmitter, requestid, lid, cid, title, url, homepagetitle, homepage, version, size, platform, description, screenshot, features, dhistory, forumid
			FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . " WHERE requestid=" . $_GET['requestid'];
	$mod_array = $xoopsDB->fetchArray($xoopsDB->query($sql));
	unset($sql);

	$sql = "SELECT submitter, lid, cid, title, url, homepagetitle, homepage, version, size, platform, description, screenshot, features, dhistory, forumid
			FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=" . $mod_array['lid'] ;
	$orig_array = $xoopsDB->fetchArray($xoopsDB->query($sql));
	unset($sql);

	$orig_user = new XoopsUser($orig_array['submitter']);
	$submittername = xoops_getLinkedUnameFromId($orig_array['submitter']); // $orig_user->getvar("uname");
	$submitteremail = $orig_user->getUnameFromId("email");

	echo "<div><b>" . _AM_PDD_MOD_MODPOSTER . "</b> $submittername</div>";
	$not_allowed = array("lid", "submitter", "requestid", "modifysubmitter");
	$sform = new XoopsThemeForm(_AM_PDD_MOD_ORIGINAL, "storyform", "index.php", "post", true);
	foreach ($orig_array as $key => $content)
	{
		if (in_array($key , $not_allowed))
		{
			continue;
		}
		$lang_def = constant("_AM_PDD_MOD_" . strtoupper($key));

		if ($key == "platform")
		$content = $xoopsModuleConfig[$key][$orig_array[$key]];
		if ($key == "cid")
		{
			$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $content . "";
			$row = $xoopsDB->fetchArray($xoopsDB->query($sql));
			$content = $row['title'];
		}
		if ($key == "forumid")
		{
			$content = '';
			$modhandler = &xoops_gethandler('module');
			$xoopsforumModule = &$modhandler->getByDirname('newbb');
			$sql = "SELECT title FROM " . $xoopsDB->prefix('bb_categories') . " WHERE cid=" . $content . "";
			if ($xoopsforumModule && $content > 0)
			{
				$content = "<a href='" . XOOPS_URL . "/modules/newbb/viewforum.php?forum=" . $content . "'>Forumid</a>";
			}
			else
			{
				$content = '';
			}
		}
		if ($key == "screenshot")
		{
			$content = '';
			if ($content > 0)
			$content = "<img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['screenshots'] . "/" . $logourl . "' width='" . $xoopsModuleConfig['shotwidth'] . "' alt='' />";
		}
		if ($key == "features")
		{
			if ($content != '')
			{
				$downrequirements = explode('|', trim($content));
				foreach ($downrequirements as $bi)
				{
					$content = "<li>" . $bi;
				}
			}
		}
		if ($key == "dhistory")
		{
			$content = $myts->displayTarea($content, 1, 0, 0, 0, 1);;
		}
		$sform->addElement(new XoopsFormLabel($lang_def, $content));
	}
	$sform->display();

	$orig_user = new XoopsUser($mod_array['modifysubmitter']);
	$submittername = xoops_getLinkedUnameFromId($mod_array['modifysubmitter']);
	$submitteremail = $orig_user->getUnameFromId("email");

	echo "<div><b>" . _AM_PDD_MOD_MODIFYSUBMITTER . "</b> $submittername</div>";
	$sform = new XoopsThemeForm(_AM_PDD_MOD_PROPOSED, "storyform", "modifications.php", "post", true);
	foreach ($mod_array as $key => $content)
	{
		if (in_array($key, $not_allowed))
		{
			Continue;
		}
		$lang_def = constant("_AM_PDD_MOD_" . strtoupper($key));

		if ($key == "platform")
		$content = $xoopsModuleConfig[$key][$orig_array[$key]];
		if ($key == "cid")
		{
			$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $content . "";
			$row = $xoopsDB->fetchArray($xoopsDB->query($sql));
			$content = $row['title'];
		}
		if ($key == "forumid")
		{
			$content = '';
			$modhandler = &xoops_gethandler('module');
			$xoopsforumModule = &$modhandler->getByDirname('newbb');
			$sql = "SELECT title FROM " . $xoopsDB->prefix('bb_categories') . " WHERE cid=" . $content . "";
			$content = '';
			if ($xoopsforumModule && $content > 0)
			{
				$content = "<a href='" . XOOPS_URL . "/modules/newbb/viewforum.php?forum=" . $content . "'>Forumid</a>";
			}
		}
		if ($key == "screenshot")
		{
			$content = '';
			if ($content > 0)
			$content = "<img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['screenshots'] . "/" . $logourl . "' width='" . $xoopsModuleConfig['shotwidth'] . "' alt='' />";
		}
		if ($key == "features")
		{
			if ($content != '')
			{
				$downrequirements = explode('|', trim($content));
				foreach ($downrequirements as $bi)
				{
					$content = "<li>" . $bi;
				}
			}
		}
		if ($key == "dhistory")
		{
			$content = $myts->displayTarea($content, 1, 0, 0, 0, 1);;
		}
		$sform->addElement(new XoopsFormLabel($lang_def, $content));
	}

	$button_tray = new XoopsFormElementTray('', '');
	$button_tray->addElement(new XoopsFormHidden('requestid', $requestid));
	$button_tray->addElement(new XoopsFormHidden('lid', $mod_array['requestid']));
	$hidden = new XoopsFormHidden('op', 'changeModReq');
	$button_tray->addElement($hidden);
	if ($mod_array)
	{
		$butt_dup = new XoopsFormButton('', '', _AM_PDD_BAPPROVE, 'submit');
		$butt_dup->setExtra('onclick="this.form.elements.op.value=\'changeModReq\'"');
		$button_tray->addElement($butt_dup);
	}
	$butt_dupct2 = new XoopsFormButton('', '', _AM_PDD_BIGNORE, 'submit');
	$butt_dupct2->setExtra('onclick="this.form.elements.op.value=\'ignoreModReq\'"');
	$button_tray->addElement($butt_dupct2);
	$sform->addElement($button_tray);
	$sform->display();

	xoops_cp_footer();
	exit();
	break;

	case "changeModReq":
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}
	global $xoopsDB, $_POST, $eh, $myts;

	$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . " WHERE requestid=" . $_POST['requestid'] . "";
	$down_array = $xoopsDB->fetchArray($xoopsDB->query($sql));

	$lid = $down_array['lid'];
	$cid = $down_array['cid'];
	$title = $down_array['title'];
	$url = $down_array['url'];
	$homepage =$down_array['homepage'];
	$homepagetitle = $down_array['homepagetitle'];
	$version = $down_array['version'];
	$size = $down_array['size'];
	$platform = $down_array['platform'];
	$publisher = $xoopsUser -> uname();
	$screenshot = $down_array['screenshot'];
	$description = $down_array['description'];
	$features = $down_array['features'];
	$dhistory = $down_array['dhistory'];
	$submitter = $down_array['modifysubmitter'];
	$updated = time();

	$xoopsDB->query("UPDATE " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " SET cid = $cid, title = '$title',
			url = '$url', features = '$features', homepage = '$homepage', submitter = '$submitter', version = '$version', size = $size, platform = '$platform',
			screenshot = '$screenshot', publisher = '$publisher', status = '2', homepagetitle = '$homepagetitle', dhistory = '$dhistory', updated = '$updated', 
			description = '$description' WHERE lid = $lid");
	$sql = "DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . " WHERE requestid = " . $_POST['requestid'] . "";
	$result = $xoopsDB->query($sql);
	redirect_header('index.php', 1, _AM_PDD_MOD_REQUPDATED);
	break;

	case "ignoreModReq":
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}
	global $xoopsDB, $_POST;
	$sql = sprintf("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . " WHERE requestid = " . $_POST['requestid'] . "");
	$xoopsDB->query($sql);
	redirect_header('index.php', 1, _AM_PDD_MOD_REQDELETED);
	break;

	case 'main':
	default:

	include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

	global $xoopsModuleConfig;
	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$mytree = new XoopsTree($xoopsDB->prefix("PDdownloads{$mydirnumber}_mod"), "requestid", 0);

	global $xoopsDB, $myts, $mytree, $xoopsModuleConfig;
	$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . " ORDER BY requestdate DESC" ;
	$result = $xoopsDB->query($sql, $xoopsModuleConfig['admin_perpage'] , $start);
	$totalmodrequests = $xoopsDB->getRowsNum($xoopsDB->query($sql));

	xoops_cp_header();
	PDd_adminmenu();
	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_MOD_MODREQUESTSINFO . "</legend>\n
		<div style='padding: 8px;'>" . _AM_PDD_MOD_TOTMODREQUESTS . " <b>$totalmodrequests</></div>\n
		</fieldset><br />\n

		<table width='100%' cellspacing='1' cellpadding='2' border='0' class='outer'>\n
		<tr>\n
		<th align='center'><b>" . _AM_PDD_MOD_MODID . "</b></th>\n
		<th><b>" . _AM_PDD_MOD_MODTITLE . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MOD_MODIFYSUBMIT . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MOD_DATE . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_ACTION . "</b></th>\n
		</tr>\n";
	if ($totalmodrequests > 0)
	{
		while ($down_arr = $xoopsDB->fetchArray($result))
		{
			$path = $mytree->getNicePathFromId($down_arr['requestid'], "title", "modifications.php?op=listModReqshow&requestid");
			$path = str_replace("/", "", $path);
			$path = str_replace(":", "", trim($path));
			$title = trim($path);
			$submitter = xoops_getLinkedUnameFromId($down_arr['modifysubmitter']);;
			$requestdate = formatTimestamp($down_arr['requestdate'], $xoopsModuleConfig['dateformat']);
			echo "
		<tr>\n
		<td class='head' align='center'>" . $down_arr['requestid'] . "</td>\n
		<td class='even'>" . $title . "</td>\n
		<td class='even' align='center'>" . $submitter . "</td>\n
		<td class='even' align='center'>" . $requestdate . "</td>\n
		<td class='even' align='center'> <a href='modifications.php?op=listModReqshow&amp;requestid=" . $down_arr['requestid'] . "'>"._AM_PDD_MOD_VIEW."</a></td>\n
		</tr>\n";
		}
	}
	else
	{
		echo "<tr><td class='head' align='center' colspan='7'>" . _AM_PDD_MOD_NOMODREQUEST . "</td></tr>";
	}
	echo "</table>\n";

	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	$page = ($totalmodrequests > $xoopsModuleConfig['admin_perpage']) ? _AM_PDD_MINDEX_PAGE : '';
	$pagenav = new XoopsPageNav($totalmodrequests, $xoopsModuleConfig['admin_perpage'], $start, 'start');
	echo "<div align='right' style='padding: 8px;'>" . $page . '' . $pagenav->renderImageNav() . '</div>';
	xoops_cp_footer();
}

?>