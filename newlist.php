<?php
/**
 * $Id: newlist.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */
include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include XOOPS_ROOT_PATH . '/header.php';

$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_newlistindex.html";
global $xoopsDB, $xoopsModule, $xoopsUser, $xoopsModuleConfig;
$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');
$imageheader = PDd_imageheader();
$xoopsTpl->assign('imageheader', $imageheader);
$time_cur = time();
$dailydownloads = array();
$newdownloadshowdays = (!isset($_GET['newdownloadshowdays'])) ? 7 : $_GET['newdownloadshowdays'];
$xoopsTpl->assign('newdownloadshowdays', $newdownloadshowdays);
for($i = 0;$i < $newdownloadshowdays;$i++) {
	$key = $newdownloadshowdays - ($i + 1);
	$time = $time_cur - (86400 * $key);
	$dailydownloads[$key]['newdownloaddayRaw'] = $time;
	$dailydownloads[$key]['newdownloadView'] = formatTimestamp($time, "F d, Y");
	$dailydownloads[$key]['totaldownloads'] = 0;
}
$duration_week = ($time_cur - (86400 * 7));
$allmonthdownloads = 0;
$allweekdownloads = 0;
$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " ";
$result = $xoopsDB->query($sql);
while ($myrow = $xoopsDB->fetcharray($result)) {
	$duration = ($time_cur - (86400 * 30));
	$updated = $myrow['updated'];
	$published = $myrow['published'];
	$expired = $myrow['expired'];
	$offline = $myrow['offline'];
	$cid = $myrow['cid'];
	$lid = $myrow['lid'];
	if (($published >= $duration && $published <= $time_cur) || ($updated >= $duration && $updated <= $time_cur) && ($expired = 0 || $expired > $time_cur) && $offline = 0 && $gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $cid, $groups, $module_id) && $gperm_handler->checkRight("PDDownFilePerm{$mydirnumber}", $lid, $groups, $module_id))
	{
		$allmonthdownloads++;
		if ($published >= $duration_week) {
			$allweekdownloads++;
		}
	}
	$duration = ($time_cur - (86400 * $newdownloadshowdays));
	if (($published >= $duration && $published <= $time_cur) || ($updated >= $duration && $updated <= $time_cur) && ($expired = 0 || $expired > $time_cur) && $offline = 0 && $gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $cid, $groups, $module_id) && $gperm_handler->checkRight("PDDownFilePerm{$mydirnumber}", $lid, $groups, $module_id))
	{
		$key = intval(($time_cur - $published) / 86400);
		$dailydownloads[$key]['totaldownloads']++;
	}
}
$xoopsTpl->assign('allweekdownloads', $allweekdownloads);
$xoopsTpl->assign('allmonthdownloads', $allmonthdownloads);
$xoopsTpl->assign('mydirname', "{$mydirname}_download.html");

/**
* List Last VARIABLE Days of Downloads
*/
ksort($dailydownloads);
reset($dailydownloads);
$xoopsTpl->assign('dailydownloads', $dailydownloads);
unset($dailydownloads);
$sql = "SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ORDER BY a.published DESC";

$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , 0);
while ($down_arr = $xoopsDB->fetchArray($result)) {
	include XOOPS_ROOT_PATH . "/modules/$mydirname/include/downloadinfo.php";
}
/**
     * Screenshots display
     */
if ($xoopsModuleConfig['screenshot']) {
	$xoopsTpl->assign('shots_dir', $xoopsModuleConfig['screenshots']);
	$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
	$xoopsTpl->assign('shotheight', $xoopsModuleConfig['shotheight']);
	$xoopsTpl->assign('show_screenshot', true);
}
include XOOPS_ROOT_PATH . '/footer.php';

?>