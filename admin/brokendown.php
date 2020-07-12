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

$op = '';

if (!isset($_POST['op']))
{
	$op = isset($_GET['op']) ? $_GET['op'] : 'listBrokenDownloads';
}
else
{
	$op = $_POST['op'];
}

$lid = (isset($_GET['lid'])) ? $_GET['lid'] : 0;

switch ($op)
{
	case "updateNotice":
	global $xoopsDB;
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check(true, $_REQUEST['t'])) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	if (isset($_GET['con']))
	{
		$confirmed = (isset($_GET['con']) && $_GET['con'] == 0) ? 1 : 1;
		$xoopsDB->queryF("UPDATE " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " SET confirmed = '$confirmed'
			WHERE lid='$lid'");
		$update_mess = _AM_PDD_BROKEN_NOWCON;
	}
	redirect_header("index.php?op=Download&lid=$lid",3,_AM_PDD_BROKEN_NOWCON);
	break;

	case "delBrokenDownloads":
	global $xoopsDB;
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check(true, $_REQUEST['t'])) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	$xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " WHERE lid = '$lid'");
	$xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = '$lid'");
	redirect_header("brokendown.php?op=default", 1, _AM_PDD_BROKENFILEDELETED);
	exit();
	break;

	case "ignoreBrokenDownloads":
	global $xoopsDB;
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check(true, $_REQUEST['t'])) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	$xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " WHERE lid = '$lid'");
	redirect_header("brokendown.php?op=default", 1, _AM_PDD_BROKEN_FILEIGNORED);
	break;

	case "listBrokenDownloads":
	case "default":

	global $xoopsDB, $imagearray, $xoopsModule;
	$result = $xoopsDB->query("SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " ORDER BY reportid");
	$totalbrokendownloads = $xoopsDB->getRowsNum($result);

	xoops_cp_header();

	PDd_adminmenu();
	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_BROKEN_REPORTINFO . "</legend>\n
		<div style='padding: 8px;'>" . _AM_PDD_BROKEN_REPORTSNO . "&nbsp;<b>$totalbrokendownloads</b><div>\n
		<div style='padding: 8px;'>\n
		<ul><li>" . $imagearray['ignore'] . " " . _AM_PDD_BROKEN_IGNOREDESC . "</li>\n
		<li>" . $imagearray['editimg'] . " " . _AM_PDD_BROKEN_EDITDESC . "</li>
		<li>" . $imagearray['deleteimg'] . " " . _AM_PDD_BROKEN_DELETEDESC . "</li>\n
		<li>" . $imagearray['ack_yes'] . " " . _AM_PDD_BROKEN_ACKDESC . "</li>
		</ul></div>\n
		</fieldset><br />\n

		<table width='100%' border='0' cellspacing='1' cellpadding = '2' class='outer'>\n
		<tr align = 'center'>\n
		<th width = '3%' align = 'center'>" . _AM_PDD_BROKEN_ID . "</th>\n
		<th width = '35%' align = 'left'>" . _AM_PDD_BROKEN_TITLE . "</th>\n
		<th>" . _AM_PDD_BROKEN_REPORTER . "</th>\n
		<th>" . _AM_PDD_BROKEN_FILESUBMITTER . "</th>\n
		<th>" . _AM_PDD_BROKEN_DATESUBMITTED . "</th>\n
		<th align='center'>" . _AM_PDD_BROKEN_ACTION . "</th>\n
		</tr>\n
		";

	if ($totalbrokendownloads == 0)
	{
		echo "<tr align = 'center'><td align = 'center' class='head' colspan = '6'>" . _AM_PDD_BROKEN_NOFILEMATCH . "</td></tr>";
	}
	else
	{
		while (list($reportid, $lid, $sender, $ip, $date, $confirmed, $acknowledged) = $xoopsDB->fetchRow($result))
		{
			$result2 = $xoopsDB->query("SELECT cid, title, url, submitter FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=$lid");
			list($cid, $fileshowname, $url, $submitter) = $xoopsDB->fetchRow($result2);

			if ($sender != 0)
			{
				$result3 = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid=" . $sender . "");
				list($sendername, $email) = $xoopsDB->fetchRow($result3);
			}

			$result4 = $xoopsDB->query("SELECT uname, email FROM " . $xoopsDB->prefix("users") . " WHERE uid=" . $sender . "");
			list($ownername, $owneremail) = $xoopsDB->fetchRow($result4);

			echo "
		<tr align = 'center'>\n
		<td class = 'head'>$reportid</td>\n
		<td class = 'even' align = 'left'><a href='" . XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . "&lid=" . $lid . "' target='_blank'>" . $fileshowname . "</a></td>\n
		";
			if ($email == "")
			{
				echo "<td class = 'even'>$sendername ($ip)";
			}
			else
			{
				echo "<td class = 'even'><a href='mailto:$email'>$sendername</a> ($ip)";
			}
			if ($owneremail == '')
			{
				echo "<td class = 'even'>$ownername";
			}
			else
			{
				echo "<td class = 'even'><a href='mailto:$owneremail'>$ownername</a>";
			}
			echo "
		</td>\n
		<td class='even' align='center'>" . formatTimestamp($date, $xoopsModuleConfig['dateformat']) . "</td>\n
		<td align='center' class = 'even' nowrap>\n
		<a href='brokendown.php?op=ignoreBrokenDownloads&lid=$lid&t=".$GLOBALS['xoopsSecurity']->createToken()."'>" . $imagearray['ignore'] . "</a>\n";
			$con_image = ($confirmed) ? $imagearray['con_yes'] : $imagearray['con_no'];
			echo "
		<a href='brokendown.php?op=updateNotice&lid=$lid&con=$confirmed&t=".$GLOBALS['xoopsSecurity']->createToken()."'> " . $imagearray['editimg'] . " </a>\n
		<a href='brokendown.php?op=delBrokenDownloads&lid=$lid&t=".$GLOBALS['xoopsSecurity']->createToken()."'>" . $imagearray['deleteimg'] . "</a>\n
		" . $con_image . "</td></tr>\n";
		}
	}
	echo"</table>";
}
xoops_cp_footer();

?>
