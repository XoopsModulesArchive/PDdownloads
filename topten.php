<?php
/**
 * $Id: topten.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

global $xoopsDB, $xoopsUser;

$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_topten.html";

$groups = (is_object($xoopsUser)) ? $xoopsUser -> getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule -> getVar('mid');
$gperm_handler = & xoops_gethandler('groupperm');
$time_cur = time();

include XOOPS_ROOT_PATH . '/header.php';

$action_array = array('hit' => 0, 'rate' => 1);
$list_array = array('hits', 'rating');
$lang_array = array(_MD_PDD_HITS, _MD_PDD_RATING);

$sort = (isset($_GET['list']) && in_array($_GET['list'], $action_array)) ? $_GET['list'] : 'rate';
$thiz = $action_array[$sort];
$sortDB = $list_array[$thiz];

$catarray['imageheader'] = PDd_imageheader();
$catarray['letters'] = PDd_letters();
$catarray['toolbar'] = PDd_toolbar();
$xoopsTpl -> assign('catarray', $catarray);

$arr = array();

$result = $xoopsDB -> query("SELECT a.cid, a.title, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.cid = b.gperm_itemid AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownCatPerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] AND a.pid=0");

$e = 0;
$rankings = array();
while (list($cid, $ctitle) = $xoopsDB -> fetchRow($result))
{
	$query = "SELECT a.lid, a.cid, a.title, a.hits, a.rating, a.votes, a.platform, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] AND (cid=$cid";

	$arr = $mytree -> getAllChildId($cid);
	for($i = 0;$i < count($arr);$i++)
	{
		$query .= " or cid=" . $arr[$i] . "";
	}
	$query .= ") order by " . $sortDB . " DESC";
	$result2 = $xoopsDB -> query($query, 10, 0);
	$filecount = $xoopsDB -> getRowsNum($result2);

	if ($filecount > 0)
	{
		$rankings[$e]['title'] = $myts -> htmlSpecialChars($ctitle);
		$rank = 1;

		while (list($did, $dcid, $dtitle, $hits, $rating, $votes) = $xoopsDB -> fetchRow($result2))
		{
			$catpath = $mytree -> getPathFromId($dcid, "title");
			$catpath = basename($catpath);

			$dtitle = $myts -> htmlSpecialChars($dtitle);

			$rankings[$e]['file'][] = array('id' => $did, 'cid' => $dcid, 'rank' => $rank, 'title' => $dtitle, 'category' => $catpath, 'hits' => $hits, 'rating' => number_format($rating, 2), 'votes' => $votes);
			$rank++;
		}
		$e++;
	}
}

$xoopsTpl -> assign('lang_sortby' , $lang_array[$thiz]);

$xoopsTpl -> assign('rankings', $rankings);

include XOOPS_ROOT_PATH . '/footer.php';
?>
