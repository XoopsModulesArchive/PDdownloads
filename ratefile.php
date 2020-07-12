<?php
/* $Id: ratefile.php
* Module: PD-Downloads
* Version: v1.2
* Release Date: 21. Dec 2005
* Author: Power-Dreams Team
* Licence: GNU
*/

include 'header.php';
$ip = getenv("REMOTE_ADDR");
$time_cur = time();
if (empty($xoopsUser))
$ratinguser = 0;
else
$ratinguser = $xoopsUser -> getVar('uid');

if (!empty($_POST['submit']))
{
	$lid = intval($_POST['lid']);
	$cid = intval($_POST['cid']);
	$rating = intval($_POST['rating']);

	if ($rating == "--")
	{
		redirect_header("ratefile.php?cid=" . $cid . "&lid=" . $lid . "", 4, _MD_PDD_NORATING);
		exit();
	}

	$newid = $xoopsDB -> genId($xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . "_ratingid_seq");
	$sql = sprintf("INSERT INTO %s (ratingid, lid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES (%u, %u, %u, %u, '%s', %u)", $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata"), $newid, $lid, $ratinguser, $rating, $ip, $time_cur);
	$xoopsDB -> query($sql);
	// All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
	PDd_updaterating($lid);
	$ratemessage = _MD_PDD_VOTEAPPRE . "<br />" . sprintf(_MD_PDD_THANKYOU, $xoopsConfig['sitename']);
	redirect_header('index.php', 4, $ratemessage);
	exit();
}
else
{
	$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_ratefile.html";
	include XOOPS_ROOT_PATH . '/header.php';
	$lid = intval($_GET['lid']);
	$cid = intval($_GET['cid']);
	$anonwaitdays = 1;
	$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$module_id = $xoopsModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	$imageheader = PDd_imageheader();

	if ($ratinguser != 0)
	{
		$result1 = $xoopsDB -> query("SELECT submitter FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=$lid");
		while (list($ratinguserDB) = $xoopsDB -> fetchRow($result1))
		{
			if ($ratinguserDB == $ratinguser)
			{
				redirect_header("index.php", 4, _MD_PDD_CANTVOTEOWN);
				exit();
			}
		}
		$result = $xoopsDB -> query("SELECT ratinguser FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid=$lid");
		while (list($ratinguserDB) = $xoopsDB -> fetchRow($result))
		{
			if ($ratinguserDB == $ratinguser)
			{
				redirect_header('index.php', 4, _MD_PDD_VOTEONCE);
				exit();
			}
		}
	}
	else
	{
		$yesterday = (time() - (86400 * $anonwaitdays));
		$result = $xoopsDB -> query("SELECT COUNT(*) FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid=$lid AND ratinguser=0 AND ratinghostname = '$ip'  AND ratingtimestamp > $yesterday");
		list($anonvotecount) = $xoopsDB -> fetchRow($result);
		if ($anonvotecount >= 1)
		{
			redirect_header("index.php", 4, _MD_PDD_VOTEONCE);
			exit();
		}
	}

	$result = $xoopsDB->query("SELECT a.title, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE (a.lid = $lid AND b.gperm_itemid = $lid) AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]");
	$down_arr = $xoopsDB->fetchArray($result);

	if (!$down_arr)
	checkentry($lid, $groups, $module_id, 1);

	$xoopsTpl -> assign('file', array('id' => $lid, 'cid' => $cid, 'title' => $myts -> htmlSpecialChars($down_arr['title']), 'imageheader' => $imageheader));
	include XOOPS_ROOT_PATH . '/footer.php';
}
include XOOPS_ROOT_PATH.'/footer.php';

?>