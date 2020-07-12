<?php
/**
 * $Id: brokenfile.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';

if (!empty($_POST['submit'])) {

	global $xoopsModule, $xoopsModuleConfig, $xoopsUser;

	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check()) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}

	$sender = (is_object($xoopsUser)) ? $xoopsUser->getVar('uid') : 0;
	$ip = getenv("REMOTE_ADDR");
	$lid = intval($_POST['lid']);
	$time = time();

	$sql = sprintf("INSERT INTO ".$xoopsDB->prefix("PDdownloads{$mydirnumber}_broken")." (reportid, lid, sender, ip, date, confirmed, acknowledged ) VALUES ( '', '$lid', '$sender', '$ip', '$time', '0', '0')");
	$result = $xoopsDB->query($sql);

	$newid = $xoopsDB->getInsertId();
	$tags = array();
	$tags['BROKENREPORTS_URL'] = XOOPS_URL . "/modules/$mydirname/admin/index.php?op=listBrokenDownloads";
	$notification_handler = &xoops_gethandler('notification');
	$notification_handler->triggerEvent('global', 0, 'file_broken', $tags);

	$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $lid AND published > 0 AND published <= " . time() . " AND (expired = 0 OR expired > " . time() . ")";
	$down_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));
	unset($sql);

	$user = new XoopsUser(intval($down_arr['submitter']));
	$subdate = formatTimestamp($down_arr['date'], $xoopsModuleConfig['dateformat']);
	$cid = $down_arr['cid'];
	$title = $down_arr['title'];
	$subject = _MD_PDD_BROKENREPORTED;

	$xoopsMailer = &getMailer();
	$xoopsMailer->useMail();
	$template_dir = XOOPS_ROOT_PATH . "/modules/$mydirname/language/" . $xoopsConfig['language'] . "/mail_template";

	$xoopsMailer->setTemplateDir($template_dir);
	$xoopsMailer->setTemplate('filebroken_notify.tpl');
	$xoopsMailer->setToEmails($user->email());
	$xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
	$xoopsMailer->setFromName($xoopsConfig['sitename']);
	$xoopsMailer->assign("X_UNAME", $user->uname());
	$xoopsMailer->assign("SITENAME", $xoopsConfig['sitename']);
	$xoopsMailer->assign("X_ADMINMAIL", $xoopsConfig['adminmail']);
	$xoopsMailer->assign('X_SITEURL', XOOPS_URL . '/');
	$xoopsMailer->assign("X_TITLE", $title);
	$xoopsMailer->assign("X_SUB_DATE", $subdate);
	$xoopsMailer->assign('X_DOWNLOAD', XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . '&lid=' . $lid);
	$xoopsMailer->setSubject($subject);
	$xoopsMailer->send();
	redirect_header('index.php', 2, _MD_PDD_BROKENREPORTED);
	exit();
} else {
	$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_brokenfile.html";
	include XOOPS_ROOT_PATH . '/header.php';
	$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$module_id = $xoopsModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	$time_cur = time();
	$catarray['imageheader'] = PDd_imageheader();
	$xoopsTpl->assign('catarray', $catarray);

	$lid = (isset($_GET['lid']) && $_GET['lid'] > 0) ? intval($_GET['lid']) : 0;
	$result = $xoopsDB->query("SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE (a.lid = $lid AND b.gperm_itemid = $lid) AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]");
	$down_arr = $xoopsDB->fetchArray($result);

	if (!$down_arr) {
		$result2 = $xoopsDB->query("SELECT lid FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $lid");
		if ($xoopsDB->getRowsNum($result2) > 0)
		redirect_header(XOOPS_URL,3,_NOPERM);
		else
		redirect_header("index.php", 1, _MD_PDD_NODOWNLOAD);
		exit();
	}
	unset($sql);

	$sql = "SELECT lid, date FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_broken") . " WHERE lid = $lid";
	$broke_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));

	if (!empty($broke_arr))
	{
		global $xoopsModuleConfig;

		$broken['title'] = trim($down_arr['title']);
		$broken['date'] = formatTimestamp($broke_arr['date'], $xoopsModuleConfig['dateformat']);

		$xoopsTpl->assign('broken', $broken);
		$xoopsTpl->assign('brokenreport', true);
		header("Refresh: 5; url=index.php");
	}
	else
	{
		$down_homepage = formatURL(trim($down_arr['homepage']));
		$down['title'] = trim($down_arr['title']);
		$down['homepage'] = $myts->makeClickable($down_homepage);
		$time = ($down_arr['updated'] != 0) ? $down_arr['updated'] : $down_arr['published'];
		$down['updated'] = formatTimestamp($time, $xoopsModuleConfig['dateformat']);
		$down['subdate'] = ($down_arr['updated'] != 0) ? _MD_PDD_UPDATEDON : _MD_PDD_SUBMITDATE;
		$down['publisher'] = xoops_getLinkedUnameFromId(intval($down_arr['submitter']));

		$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
		$xoopsTpl->assign('file_id', $lid);
		$xoopsTpl->assign('down', $down);
	}
	include_once XOOPS_ROOT_PATH . '/footer.php';
}

?>