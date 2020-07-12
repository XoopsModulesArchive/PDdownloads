<?php
/**
 * $Id: index.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

global $xoopsModuleConfig, $xoopsModule, $xoopsUser;

include XOOPS_ROOT_PATH . '/header.php';
$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_index.html";
/**
 * Begin Main page Heading etc
 */
$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_indexpage") . " ";
$head_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));
$catarray['imageheader'] = PDd_imageheader();
$catarray['indexheading'] = $myts->displayTarea($head_arr['indexheading']);
$catarray['indexheaderalign'] = $head_arr['indexheaderalign'];
$catarray['indexfooteralign'] = $head_arr['indexfooteralign'];

$html = ($head_arr['nohtml']) ? 0 : 1;
$smiley = ($head_arr['nosmiley']) ? 0 : 1;
$xcodes = ($head_arr['noxcodes']) ? 0 : 1;
$images = ($head_arr['noimages']) ? 0 : 1;
$breaks = ($head_arr['nobreak']) ? 1 : 0;

$catarray['indexheader'] = $myts->displayTarea($head_arr['indexheader'], $html, $smiley, $xcodes, $images, $breaks);
$catarray['indexfooter'] = $myts->displayTarea($head_arr['indexfooter'], $html, $smiley, $xcodes, $images, $breaks);
$catarray['letters'] = PDd_letters();
$catarray['toolbar'] = PDd_toolbar();
$xoopsTpl->assign('catarray', $catarray);
$xoopsTpl->assign('mydirname', "{$mydirname}_download.html");
/**
 * End main page Headers
 */

$xoopsTpl->assign('dividecategory', $xoopsModuleConfig['dividecategory']) ;
$count = 1;
$countcat = 0;

$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$module_id = $xoopsModule->getVar('mid');
$gperm_handler = &xoops_gethandler('groupperm');

$listings = PDd_getTotalItems();

$result = $xoopsDB->query("SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.cid = b.gperm_itemid AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownCatPerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] AND a.pid = 0 ORDER BY a.weight");
while ($myrow = $xoopsDB->fetchArray($result))
{
	$totaldownload = PDd_getTotalItems($myrow['cid'], 1);
	$indicator = PDd_isnewimage($totaldownload['published']);

	$countcat++;
	$subcategories = "";
	$title = $myts->htmlSpecialChars($myrow['title']);

	if ($xoopsModuleConfig['allowrss'])
	$title .= "</b>&nbsp;<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=" . $myrow['cid'] . "'>(RSS)</a>";

	if ($xoopsModuleConfig['subcats'])
	{
		$space = 0;
		$chcount = 0;
		$arr = $mytree->getFirstChild($myrow['cid'], "title");

		foreach($arr as $ele)
		{
			if ($gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $ele['cid'] , $groups, $module_id))
			{
				$countcat++;
				$chtitle = $myts->htmlSpecialChars($ele['title']);
				if ($chcount > 5)
				{
					$subcategories .= "...";
					break;
				}
				if ($space > 0) $subcategories .= "<br />";
				$subcategories .= "<a href='" . XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $ele['cid'] . "'>" . $chtitle . "</a>";
				if ($xoopsModuleConfig['allowrss'])
				$subcategories .= "&nbsp;<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=" . $ele['cid'] . "'>(RSS)</a>";

				$subtotaldownload = PDd_getTotalItems($ele['cid']);
				$subcategories .= "&nbsp;(".$subtotaldownload['count'].")";
				$space++;
				$chcount++;
			}
		}
	}

	if (is_file(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['catimage'] . "/" . $myts->htmlSpecialChars($myrow['imgurl'])) && !empty($myrow['imgurl']))
	{
		if ($xoopsModuleConfig['usethumbs'] && function_exists('gd_info'))
		{
			$imgurl = down_createthumb($myts->htmlSpecialChars($myrow['imgurl']), $xoopsModuleConfig['catimage'],
			"thumbs", $xoopsModuleConfig['shotwidth'], $xoopsModuleConfig['shotheight'],
			$xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect']);
		}
		else
		$imgurl = XOOPS_URL . "/" . $xoopsModuleConfig['catimage'] . "/" . $myts->htmlSpecialChars($myrow['imgurl']);
	}
	else
	$imgurl = $indicator['image'];

	$xoopsTpl->append('categories', array('image' => $imgurl, 'id' => $myrow['cid'], 'title' => $title,
	'subcategories' => $subcategories, 'totaldownloads' => "".$totaldownload['count']."",
	'count' => $count, 'alttext' => $indicator['alttext']));
	$count++;
}
switch ($countcat)
{
	case "1":
	$lang_ThereAre = _MD_PDD_THEREIS;
	break;
	default:
	$lang_ThereAre = _MD_PDD_THEREARE;
	break;
}

$xoopsTpl->assign('lang_thereare', sprintf($lang_ThereAre, $countcat, $listings['count']));

if ($xoopsModuleConfig['showdlonindex'])
{
	$time_cur = time();
	$xoopsTpl->assign('dailydownloads', 0);

	$sql = "SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ORDER BY a.published DESC";

	$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , 0);
	while ($down_arr = $xoopsDB->fetchArray($result))
	{
		include XOOPS_ROOT_PATH . "/modules/$mydirname/include/downloadinfo.php";
	}

	/**
	 * Screenshots display
	 */
	if ($xoopsModuleConfig['screenshot'])
	{
		$xoopsTpl->assign('shots_dir', $xoopsModuleConfig['screenshots']);
		$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
		$xoopsTpl->assign('shotheight', $xoopsModuleConfig['shotheight']);
		$xoopsTpl->assign('show_screenshot', true);
	}
}

include XOOPS_ROOT_PATH.'/footer.php';
?>