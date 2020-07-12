<?php
/**
 * $Id: viewcat.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: PD-Sections
 * Licence: GNU
 */

include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

global $xoopsModuleConfig, $myts, $xoopsModules;

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$orderby = isset($_GET['orderby']) ? convertorderbyin($_GET['orderby']) : $xoopsModuleConfig['filexorder'];
$cid = empty( $_GET['cid'] ) ? 0 : intval( $_GET['cid'] ) ;
$uid = empty( $_GET['uid'] ) ? 0 : intval( $_GET['uid'] ) ;
$list = isset($_GET['list'])  && $myts->addslashes($_GET['list']) ? $_GET['list'] : 0;
$selectdate = (isset($_GET['selectdate']) ? intval($_GET['selectdate']) : 0);
$xoopsOption['template_main'] = "PDdownloads{$mydirnumber}_viewcat.html";
$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$gperm_handler = &xoops_gethandler('groupperm');
$time_cur = time();
$module_id = $xoopsModule->getVar('mid');

/**
 * Begin Main page Heading etc
 */
include XOOPS_ROOT_PATH . '/header.php';

$catarray['imageheader'] = PDd_imageheader();
$catarray['letters'] = PDd_letters();
$catarray['toolbar'] = PDd_toolbar();
$xoopsTpl->assign('catarray', $catarray);

/**
 * Breadcrumb
 */
$pathstring = "<a href='index.php'>" . _MD_PDD_MAIN . "</a>&nbsp;:&nbsp;";
$pathstring .= $mytree->getNicePathFromId($cid, "title", "viewcat.php?op=");
if ($xoopsModuleConfig['allowrss'] && $cid != 0)
{
	$xoopsTpl->assign('show_rss', true);
	$xoopsTpl->assign('rss_logo', "<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=$cid'><img src='" . XOOPS_URL . "/modules/$mydirname/images/rss.gif'</a>");
}

$xoopsTpl->assign('category_id', $cid);
$xoopsTpl -> assign('letter_sortby' , $list);

$arr = $mytree->getFirstChild($cid, "weight");

$xoopsTpl->assign('dividesubcat', $xoopsModuleConfig['dividesubcat']) ;
$xoopsTpl->assign('mydirname', "PDdownloads{$mydirnumber}_download.html");

/**
 * Display Sub-categories for selected Category
 */
if (is_array($arr) > 0 && empty($list) && empty($selectdate) && empty($uid))
{
	$scount = 1;
	foreach($arr as $ele)
	{
		$checked = 1;
		if ($gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $ele['cid'], $groups, $module_id))
		{
			$sub_arr = array();
			$sub_arr = $mytree->getFirstChild($ele['cid'], "weight");
			$space = 0;
			$chcount = 0;
			$infercategories = "";
			$title = $myts->htmlSpecialChars($ele['title']);

			if ($xoopsModuleConfig['allowrss'])
			$title .= "</b>&nbsp;<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=" . $ele['cid'] . "'>(RSS)</a>";

			foreach($sub_arr as $sub_ele)
			{
				/**
             * Subitem file count
             */
				$hassubitems = PDd_getTotalItems($sub_ele['cid']);
				/**
             * Filter group permissions
             */
				if ($gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $sub_ele['cid'], $groups, $module_id))
				{
					if ($chcount > 5)
					{
						$infercategories .= "...";
						break;
					}
					if ($space > 0) $infercategories .= ", ";
					$infercategories .= "<a href='" . XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $sub_ele['cid'] . "'>" . $myts->htmlSpecialChars($sub_ele['title']) . "</a>";
					if ($xoopsModuleConfig['allowrss'])
					$infercategories .= "&nbsp;<a href='" . XOOPS_URL . "/modules/$mydirname/rss.php?cid=" . $sub_ele['cid'] . "'>(RSS)</a>";
					$infercategories .= "&nbsp;(" . $hassubitems['count'] . ")";
					$space++;
					$chcount++;
				}
			}

			if (is_file(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['catimage'] . "/" . $myts->htmlSpecialChars($ele['imgurl'])) && !empty($ele['imgurl']))
			{
				if ($xoopsModuleConfig['usethumbs'] && function_exists('gd_info'))
				{
					$imgurl = down_createthumb($myts->htmlSpecialChars($myrow['imgurl']), $xoopsModuleConfig['catimage'],
					"thumbs", $xoopsModuleConfig['shotwidth'], $xoopsModuleConfig['shotheight'],
					$xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect']);
				}
				else
				$imgurl = XOOPS_URL . "/" . $xoopsModuleConfig['catimage'] . "/" . $myts->htmlSpecialChars($ele['imgurl']);
			}
			else
			{
				$totaldownload = PDd_getTotalItems($ele['cid'], 1);
				$indicator = PDd_isnewimage($totaldownload['published']);
				$imgurl = $indicator['image'];
			}

			$totallinks = PDd_getTotalItems($ele['cid']);
			$xoopsTpl->append('subcategories', array('image' => $imgurl, 'title' => $title,
			'id' => $ele['cid'], 'infercategories' => $infercategories, 'totallinks' => $totallinks['count'],
			'count' => $scount));
			$scount++;
		}
	}
}

if (empty($checked) && !empty($cid))
checkentry($cid, $groups, $module_id);

/**
 * Show Description for Category listing
 */
$sql = "SELECT description, nohtml, nosmiley, noxcodes, noimages, nobreak FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid = $cid";
$head_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));
$html = ($head_arr['nohtml']) ? 0 : 1;
$smiley = ($head_arr['nosmiley']) ? 0 : 1;
$xcodes = ($head_arr['noxcodes']) ? 0 : 1;
$images = ($head_arr['noimages']) ? 0 : 1;
$breaks = ($head_arr['nobreak']) ? 1 : 0;
$description = $myts->displayTarea($head_arr['description'], $html, $smiley, $xcodes, $images, $breaks);
$xoopsTpl->assign('description', $description);

/**
 * Extract Download information from database
 */
$xoopsTpl->assign('show_categort_title', true);

$sql = "SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ";

if (!empty($selectdate))
{
	$sql .= "AND TO_DAYS(FROM_UNIXTIME(a.published)) = TO_DAYS(FROM_UNIXTIME(" . $selectdate . ")) ORDER BY a.published DESC";
	$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , $start);
	$total_numrows['count'] = $xoopsDB->getRowsNum($xoopsDB->query($sql));
}
elseif (!empty($list))
{
	if ( (strlen($list) > 1) || !(in_array($list, PDd_getLetters()) ) )
	redirect_header('index.php', 4, 'Invalid list option');

	$sql .= "AND a.title LIKE '" . $list . "%' ORDER BY a.$orderby";
	$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , $start);
	$total_numrows['count'] = $xoopsDB->getRowsNum($xoopsDB->query($sql));
}
elseif (!empty($uid))
{
	if ($xoopsDB->getRowsNum($xoopsDB->query( "select name from ".$xoopsDB->prefix('users')." where uid = $uid AND level != 0")) > 0)
	{
		$sql .= "AND a.submitter = $uid ORDER BY a.$orderby";
		$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , $start);
		$total_numrows['count'] = $xoopsDB->getRowsNum($xoopsDB->query($sql));
		$pathstring .= "&nbsp;".xoops_getLinkedUnameFromId($uid)."&nbsp;</b>"._AM_PDD_MYTOTAL."&nbsp;:&nbsp;".$total_numrows['count']."";
	}
	else
	{
		redirect_header("index.php", 3, _MD_PDD_NOUSER);
		exit();
	}
}
else
{
	$sql .= "AND a.cid=" . $cid . " ORDER BY a.$orderby";
	$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , $start);
	$xoopsTpl->assign('show_categort_title', false);
	$total_numrows = PDd_getTotalItems($cid);
}

$xoopsTpl->assign('category_path', $pathstring);
/**
 * Show Downloads by file
 */
if ($total_numrows['count'] > 0)
{
	while ($down_arr = $xoopsDB->fetchArray($result))
	{
		include XOOPS_ROOT_PATH . "/modules/$mydirname/include/downloadinfo.php";
	}

	/**
     * Show order box
     */
	$xoopsTpl->assign('show_links', false);
	if ($total_numrows['count'] > 1 && $cid != 0)
	{
		$xoopsTpl->assign('show_links', true);
		$orderbyTrans = convertorderbytrans($orderby);
		$xoopsTpl->assign('lang_cursortedby', sprintf(_MD_PDD_CURSORTBY, convertorderbytrans($orderby)));
		$orderby = convertorderbyout($orderby);
	}
	/**
     * Screenshots display
     */
	$xoopsTpl->assign('show_screenshot', false);
	if ($xoopsModuleConfig['screenshot'])
	{
		$xoopsTpl->assign('shots_dir', $xoopsModuleConfig['screenshots']);
		$xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
		$xoopsTpl->assign('shotheight', $xoopsModuleConfig['shotheight']);
		$xoopsTpl->assign('show_screenshot', true);
	}

	/**
     * Nav page render
     */
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	if (!empty($selectdate))
	$pagenav = new XoopsPageNav($total_numrows['count'], $xoopsModuleConfig['perpage'] , $start, 'start', 'selectdate=' . $selectdate);
	else if (!empty($list))
	$pagenav = new XoopsPageNav($total_numrows['count'], $xoopsModuleConfig['perpage'] , $start, 'start', 'list=' . $list);
	else if (!empty($uid))
	$pagenav = new XoopsPageNav($total_numrows['count'], $xoopsModuleConfig['perpage'] , $start, 'start', 'uid=' . $uid);
	else
	$pagenav = new XoopsPageNav($total_numrows['count'], $xoopsModuleConfig['perpage'] , $start, 'start', 'cid=' . $cid.'&amp;orderby='.$orderby);

	$page_nav = $pagenav->renderImageNav();
	$istrue = (isset($page_nav) && !empty($page_nav)) ? true : false;
	$xoopsTpl->assign('page_nav', $istrue);
	$xoopsTpl->assign('pagenav', $page_nav);
}
include XOOPS_ROOT_PATH . '/footer.php';

?>
