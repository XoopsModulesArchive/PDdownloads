<?php
/**
 * $Id: singlefile.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

$lid = intval($_GET['lid']);
$cid = intval($_GET['cid']);
$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_singlefile.html";
$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');
$time_cur = time();

$result = $xoopsDB->query("SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE (a.lid = $lid AND b.gperm_itemid = $lid) AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]");
$down_arr = $xoopsDB->fetchArray($result);

if (!$down_arr)
checkentry($lid, $groups, $module_id, 1);

include XOOPS_ROOT_PATH . '/header.php';

$down['imageheader'] = PDd_imageheader();
$down['id'] = intval($down_arr['lid']);
$down['cid'] = intval($down_arr['cid']);
$pathstring = "<a href='index.php'>" . _MD_PDD_MAIN . "</a>&nbsp;:&nbsp;";
$pathstring .= $mytree->getNicePathFromId($cid, "title", "viewcat.php?op=");
if ($xoopsModuleConfig['allowrss'])
{
	$xoopsTpl->assign('show_rss', true);
	$xoopsTpl->assign('rss_logo', "<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=$cid'><img src='" . XOOPS_URL . "/modules/$mydirname/images/rss.gif'</a>");
}
$down['path'] = $pathstring;

include_once XOOPS_ROOT_PATH . "/modules/$mydirname/include/downloadinfo.php";

if ($xoopsModuleConfig['screenshot'])
{
	$xoopsTpl->assign('shots_dir', $xoopsModuleConfig['screenshots']);
	$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
	$xoopsTpl->assign('shotheight', $xoopsModuleConfig['shotheight']);
	$xoopsTpl->assign('show_screenshot', true);
}
else
$xoopsTpl->assign('show_screenshot', false);

$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$gperm_handler = &xoops_gethandler('groupperm');
$time_cur = time();

$sql = "SELECT a.lid, a.cid, a.title, a.published, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.submitter = " . $down_arr['submitter'] . " AND a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ORDER BY a.published DESC";

$result = $xoopsDB->query($sql, 20, 0);

while ($arr = $xoopsDB->fetchArray($result))
{
	$downuid['title'] = $arr['title'];
	$downuid['lid'] = $arr['lid'];
	$downuid['cid'] = $arr['cid'];
	$downuid['published'] = formatTimestamp($arr['published'], $xoopsModuleConfig['dateformat']);
	$xoopsTpl->append('down_uid', $downuid);
}

if (isset($xoopsModuleConfig['copyright']) && $xoopsModuleConfig['copyright'] == 1)
{
	$xoopsTpl->assign('lang_copyright', "" . $down['title'] . " © " . _MD_PDD_COPYRIGHT . " " . date("Y") . " " . XOOPS_URL);
}
$xoopsTpl->assign('down', $down);

include XOOPS_ROOT_PATH . '/include/comment_view.php';
include XOOPS_ROOT_PATH . '/footer.php';

?>