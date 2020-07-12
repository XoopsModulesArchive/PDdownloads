<?php
/**
 * $Id: newdownloads.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';

xoops_cp_header();
PDd_adminmenu();

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
	case "approve":

	global $xoopsModule;

	$ok = (isset($_POST['ok']) && $_POST['ok'] == 1) ? intval($_POST['ok']) : 0;
	if (!isset($_POST['lid']))
	$list = isset($_GET['lid']) ? intval($_GET['lid']) : 0;
	else
	$list = intval($_POST['lid']);

	if ($ok != 1)
	xoops_confirm(array('op' => 'approve', 'lid' => $list, 'ok' => 1, ), 'newdownloads.php', _AM_PDD_SUB_WANTTOAPPROVE, '' , true);
	else
	{
		if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());

		$result = $xoopsDB->query("SELECT cid, title, notifypub FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=" . $lid . "");
		list($cid, $title, $notifypub) = $xoopsDB->fetchRow($result);
		/**
         * Update the database
         */
		$time = time();
		$publisher = $xoopsUser->getVar('uname');
		$xoopsDB->queryF("UPDATE " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " SET published = '$time.', status = '1', publisher = '$publisher' WHERE lid = " . $lid . "");

		$tags = array();
		$tags['FILE_NAME'] = $title;
		$tags['FILE_URL'] = XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . '&amp;lid=' . $lid;

		$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $cid;
		$result = $xoopsDB->query($sql);

		$row = $xoopsDB->fetchArray($result);
		$tags['CATEGORY_NAME'] = $row['title'];
		$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $cid;
		$notification_handler = &xoops_gethandler('notification');
		$notification_handler->triggerEvent('global', 0, 'new_file', $tags);
		$notification_handler->triggerEvent('category', $cid, 'new_file', $tags);

		if ($notifypub)
		$notification_handler->triggerEvent('file', $lid, 'approve', $tags);

		redirect_header('newdownloads.php', 1, _AM_PDD_SUB_NEPDILECREATED);
	}
	break;

	// List downloads waiting for validation
	case 'main':
	default:

	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	global $xoopsDB, $myts, $xoopsModuleConfig, $imagearray;

	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

	$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE published = 0 ORDER BY lid DESC" ;
	$new_array = $xoopsDB->query($sql, $xoopsModuleConfig['admin_perpage'], $start);
	$new_array_count = $xoopsDB->getRowsNum($xoopsDB->query($sql));

	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_SUB_FILESWAITINGINFO . "</legend>\n
		<div style='padding: 8px;'>" . _AM_PDD_SUB_FILESWAITINGVALIDATION . "&nbsp;<b>$new_array_count</b><div>\n
		<div div style='padding: 8px;'>\n
		<li>" . $imagearray['approve'] . " " . _AM_PDD_SUB_APPROVEWAITINGFILE . "\n
		<li>" . $imagearray['editimg'] . " " . _AM_PDD_SUB_EDITWAITINGFILE . "\n
		<li>" . $imagearray['deleteimg'] . " " . _AM_PDD_SUB_DELETEWAITINGFILE . "</div>\n
		</fieldset><br />\n

		<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>\n
		<tr>\n
		<td class='bg3' align='center' width = '3%'><b>" . _AM_PDD_MINDEX_ID . "</b></td>\n
		<td class='bg3' width = '30%'><b>" . _AM_PDD_MINDEX_TITLE . "</b></td>\n
		<td class='bg3' align='center' width = '15%'><b>" . _AM_PDD_MINDEX_POSTER . "</b></td>\n
		<td class='bg3' align='center' width = '15%'><b>" . _AM_PDD_MINDEX_SUBMITTED . "</b></td>\n
		<td class='bg3' align='center' width = '7%'><b>" . _AM_PDD_MINDEX_ACTION . "</b></td>\n
		</tr>\n";
	if ($new_array_count > 0)
	{
		while ($new = $xoopsDB->fetchArray($new_array))
		{
			$rating = number_format($new['rating'], 2);
			$title = $myts->htmlSpecialChars($new['title']);
			$url = $myts->htmlSpecialChars($new['url']);
			$url = urldecode($url);
			$homepage = $myts->htmlSpecialChars($new['homepage']);
			$version = $myts->htmlSpecialChars($new['version']);
			$size = $myts->htmlSpecialChars($new['size']);
			$platform = $myts->htmlSpecialChars($new['platform']);
			$logourl = $myts->htmlSpecialChars($new['screenshot']);
			$submitter = xoops_getLinkedUnameFromId($new['submitter']);
			$datetime = formatTimestamp($new['date'], $xoopsModuleConfig['dateformat']);
			$status = ($new['published']) ? $approved : "<a href='newdownloads.php?op=approve&lid=" . $new['lid'] . "'>" . $imagearray['approve'] . "</a>";
			$modify = "<a href='index.php?op=Download&lid=" . $new['lid'] . "'>" . $imagearray['editimg'] . "</a>";
			$delete = "<a href='index.php?op=delDownload&lid=" . $new['lid'] . "'>" . $imagearray['deleteimg'] . "</a>";

			echo "
		<tr>\n
		<td class='head' align='center'>" . $new['lid'] . "</td>\n
		<td class='even' nowrap><a href='newdownloads.php?op=edit&lid=" . $new['lid'] . "'>" . $title . "</a></td>\n
		<td class='even' align='center' nowrap>$submitter</td>\n
		<td class='even' align='center'>" . $datetime . "</td>\n
		<td class='even' align='center' nowrap>$status $modify $delete</td>\n
		</tr>\n";
		}
	}
	else
	echo "<tr ><td align='center' class='head' colspan='5'>" . _AM_PDD_SUB_NOFILESWAITING . "</td></tr>";

	echo "</table>\n";
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	$page = ($new_array_count > $xoopsModuleConfig['admin_perpage']) ? _AM_PDD_MINDEX_PAGE : '';
	$pagenav = new XoopsPageNav($new_array_count, $xoopsModuleConfig['admin_perpage'], $start, 'start');
	echo '<div align="right" style="padding: 8px;">' . $page . '' . $pagenav->renderImageNav() . '</div>';
	break;
}

xoops_cp_footer();
?>