<?php
/**
 * $Id: visit.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';

global $xoopsUser, $xoopsModuleConfig, $xoopsDB;

$agreed = (isset($_GET['agree'])) ? $_GET['agree'] : 0;

$lid = intval($_GET['lid']);
$cid = intval($_GET['cid']);

$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');
$time_cur = time();
$result = $xoopsDB->query("SELECT a.url, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE (a.lid = $lid AND b.gperm_itemid = $lid) AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]");

if (!$xoopsDB->getRowsNum($result) > 0)
checkentry($lid, $groups, $module_id, 1);

if ($agreed == 0 && $xoopsModuleConfig['check_host'])
{
	$goodhost = 0;
	$referer = parse_url(xoops_getenv('HTTP_REFERER'));
	$referer_host = $referer['host'];
	foreach ($xoopsModuleConfig['referers'] as $ref)
	{
		if (!empty($ref) && preg_match("/" . $ref . "/i", $referer_host))
		{
			$goodhost = "1";
			break;
		}
	}
	if (!$goodhost)
	{
		redirect_header(XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=$cid&lid=$lid", 20, _MD_PDD_NOPERMISETOLINK);
		exit();
	}
}

if ($xoopsModuleConfig['showDowndisclaimer'] && $agreed == 0)
{
	echo "
		<div align='center'>" . PDd_imageheader() . "</div>\n
		<h4>" . _MD_PDD_DISCLAIMERAGREEMENT . "</h4>\n
		<div>" . $myts -> displayTarea($xoopsModuleConfig['downdisclaimer'], 0, 1, 1, 1, 1) . "</div><br />\n
		<form action='visit.php' method='post'>\n
		<div align='center'><b>" . _MD_PDD_DOYOUAGREE . "</b><br /><br />\n
		<input type='button' onclick='location=\"visit.php?agree=1&lid=$lid&cid=$cid\"' class='formButton' value='" . _MD_PDD_AGREE . "' alt='" . _MD_PDD_AGREE . "' />\n
		&nbsp;\n
		<input type='button' onclick='location=\"index.php\"' class='formButton' value='" . _CANCEL . "' alt='" . _CANCEL . "' />\n
		<input type='hidden' name='lid' value='1' />\n
		<input type='hidden' name='cid' value='1' />\n
		</div></form>\n";
	exit();
}
else
{
	$xoopsDB -> queryF("UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " SET hits = hits+1 WHERE lid =$lid");
	list($url) = $xoopsDB -> fetchRow($result);
	echo "<br />" . PDd_imageheader() . "";
	$url = $myts -> htmlSpecialChars(preg_replace('/javascript:/si' , 'java script:', $url), ENT_QUOTES);
	if (!empty($url))
	{
		if ($xoopsUser)
		{
			$lang = _MD_PDD_DOWNSTARTINSEC1;
			$time = 0;
		}
		else
		{
			$lang = _MD_PDD_DOWNSTARTINSEC;
			$time = 3;
		}

		echo "
			<h4><img src='" . XOOPS_URL . "/modules/$mydirname/images/icon/downloads.gif' align='middle' alt='' /> " . _MD_PDD_DOWNINPROGRESS . "</h4>\n
			<div>$lang</div><br />\n
			<div>" . _MD_PDD_DOWNNOTSTART . "\n
			<a href='$url' target='_blank'>" . _MD_PDD_CLICKHERE . "</a>.\n
			</div>\n";
		echo "<meta http-equiv=\"refresh\" content=\"$time;url=$url\">\r\n";
	}
	else
	{
		echo "<br><br><h4>"._MD_PDD_NODOWNLOAD."</h4>";
	}
}
?>