<?php
/**
 * $ad: rss.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH.'/class/template.php';
error_reporting(0);

if (!$xoopsModuleConfig['allowrss'])
redirect_header("index.php", 3, _NOPERM);

$cid = isset($_GET['cid']) && $_GET['cid'] > 0 ? $_GET['cid'] : 0;

if (function_exists('mb_http_output'))
mb_http_output('pass');

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

$myts = & MyTextSanitizer :: getInstance(); // MyTextSanitizer object

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(3600);

if (!$tpl->is_cached('db:system_rss.html'))
{
	$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$gperm_handler = &xoops_gethandler('groupperm');
	$time_cur = time();
	$module_id = $xoopsModule->getVar('mid');

	$sql = "SELECT a.lid, a.cid, a.title, a.published, a.description, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.cid = $cid AND b.gperm_itemid = a.lid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ORDER BY a.published DESC";

	$result = $xoopsDB->query($sql, $xoopsModuleConfig['perpage'] , 0);

	while ($arr = $xoopsDB->fetchArray($result))
	{
		$sarray['title'][] = $arr['title'];
		$sarray['cid'][] = $arr['cid'];
		$sarray['lid'][] = $arr['lid'];
		$sarray['description'][] = $arr['description'];
		$sarray['published'][] = $arr['published'];
	}

	$sitename = htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES);
	$slogan = htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES);

	$tpl->assign('channel_title', "$sitename :: Downloads");
	$tpl->assign('channel_link', XOOPS_URL.'/');
	$tpl->assign('channel_title', xoops_utf8_encode($sitename));
	$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', checkEmail($xoopsConfig['adminmail'],true));	// Fed up with spam
	$tpl->assign('channel_editor', checkEmail($xoopsConfig['adminmail'],true));	// Fed up with spam
	$tpl->assign('channel_category', 'Downloads');
	$tpl->assign('channel_generator', 'XOOPS');
	$tpl->assign('channel_language', _LANGCODE);
	$tpl->assign('image_url', XOOPS_URL.'/images/logo.gif');
	$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');
	if (empty($dimention[0]))
	$width = 88;
	else
	$width = ($dimention[0] > 144) ? 144 : $dimention[0];

	if (empty($dimention[1]))
	$height = 31;
	else
	$height = ($dimention[1] > 400) ? 400 : $dimention[1];

	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);

	$result = $xoopsDB->getRowsNum($xoopsDB->query("SELECT cid FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid = $cid"));
	if ($result > 0 && !$gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $cid, $groups, $module_id))
	{
		redirect_header("index.php",3,_NOPERM);
		exit();
	}
	else if ($result == 0)
	{
		redirect_header("index.php", 1, _MD_PDD_NOCAT);
		exit();
	}
	else if (isset($sarray))
	{
		for ($a=0; $a < sizeof($sarray); $a++)
		{
			if (empty($sarray['title'][$a]))
			continue;
			$description = htmlspecialchars($sarray['description'][$a], ENT_QUOTES);
			$title = htmlspecialchars($sarray['title'][$a], ENT_QUOTES);
			$tpl->append('items', array('title' => xoops_utf8_encode($title), 'link' => XOOPS_URL."/modules/$mydirname/singlefile.php?cid=" . $sarray['cid'][$a] . '&amp;lid=' . $sarray['lid'][$a], 'guid' => XOOPS_URL."/modules/$mydirname/singlefile.php?cid=" . $sarray['cid'][$a] . '&amp;lid=' . $sarray['lid'][$a], 'pubdate' => formatTimestamp($sarray['published'][$a], 'rss'), 'description' => xoops_utf8_encode($description)));
		}
	}
}
$tpl->display('db:system_rss.html');
?>