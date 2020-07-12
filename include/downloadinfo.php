<?php
/**
 * $Id: downloadinfo.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

$down['id'] = intval($down_arr['lid']);
$down['cid'] = intval($down_arr['cid']);

$path = $mytree->getPathFromId($down_arr['cid'], "title");
$path = substr($path, 1);
$path = basename($path);
$path = str_replace("/", "", $path);
$down['category'] = $path;

$rating = round(number_format($down_arr['rating'], 0) / 2);
$rateimg = "rate$rating.gif";
$down['rateimg'] = $rateimg;
$down['votes'] = ($down_arr['votes'] == 1) ? _MD_PDD_ONEVOTE : sprintf(_MD_PDD_NUMVOTES, $down_arr['votes']);
$down['hits'] = intval($down_arr['hits']);

$xoopsTpl->assign('lang_dltimes', sprintf(_MD_PDD_DLTIMES, $down['hits']));

$down['title'] = $myts->displayTarea($down_arr['title'], 0);
$down['url'] = $down_arr['url'];

if (isset($down_arr['screenshot']))
{
	$down['screenshot_full'] = $myts->htmlSpecialChars($down_arr['screenshot']);
	if (!empty($down_arr['screenshot']) && file_exists(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['screenshots'] . "/" . xoops_trim($down_arr['screenshot'])))
	{
		if (isset($xoopsModuleConfig['usethumbs']) && $xoopsModuleConfig['usethumbs'] == 1)
		{
			$down['screenshot_thumb'] = down_createthumb($down['screenshot_full'], $xoopsModuleConfig['screenshots'], "thumbs", $xoopsModuleConfig['shotwidth'], $xoopsModuleConfig['shotheight'],
			$xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect']);
		} else {
			$down['screenshot_thumb'] = XOOPS_URL . "/" . $xoopsModuleConfig['screenshots'] . "/" . xoops_trim($down_arr['screenshot']);
		}
	}
}

$down['homepage'] = (!$down_arr['homepage'] || $down_arr['homepage'] == "http://") ? '' : $myts->htmlSpecialChars(trim($down_arr['homepage']));
if ($down['homepage'] && !empty($down['homepage']))
{
	$down['homepagetitle'] = (empty($down_arr['homepagetitle'])) ? trim($down['homepage']) : $myts->htmlSpecialChars(trim($down_arr['homepagetitle']));
	$down['homepage'] = "<a href='" . $down['homepage'] . "' target='_blank'>" . $down['homepagetitle'] . "</a>";
}
else
{
	$down['homepage'] = _MD_PDD_NOTSPECIFIED;
}

$down['comments'] = $down_arr['comments'];
$down['version'] = $down_arr['version'];
$down['downtime'] = PDd_GetDownloadTime(intval($down_arr['size']), 1, 1, 1, 1, 0);
$down['downtime'] = str_replace("|", "<br />", $down['downtime']);
$down['size'] = PDd_PrettySize(intval($down_arr['size']));

$time =$down_arr['published'];
$down['updated'] = formatTimestamp($time, $xoopsModuleConfig['dateformat']);
$is_updated = ($down_arr['status'] != 1) ? _MD_PDD_UPDATEDON : _MD_PDD_SUBMITDATE;
$down['subdate'] = $is_updated;

$down['description'] = $myts->displayTarea($down_arr['description'], 0); //no html
$down['submitter'] = xoops_getLinkedUnameFromId(intval($down_arr['submitter']));
$down['publisher'] = (isset($down_arr['publisher']) && !empty($down_arr['publisher'])) ? $myts->htmlSpecialChars($down_arr['publisher']) : _MD_PDD_NOTSPECIFIED;
$down['platform'] = $myts->htmlSpecialChars($xoopsModuleConfig['platform'][$down_arr['platform']]);
$down['history'] = $myts->displayTarea($down_arr['dhistory'],1);
$down['features'] = '';
if ($down_arr['features'])
{
	$downfeatures = explode('#', trim($down_arr['features']));
	foreach ($downfeatures as $bi)
	{
		$down['features'][] = $bi;
	}
}

$down['mail_subject'] = rawurlencode(sprintf(_MD_PDD_INTFILEFOUND, $xoopsConfig['sitename']));
$down['mail_body'] = rawurlencode(sprintf(_MD_PDD_INTFILEFOUND, $xoopsConfig['sitename']) . ':  ' . XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $down_arr['cid'] . '&lid=' . $down_arr['lid']);

$down['isadmin'] = (!empty($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->mid())) ? true : false;

$down['adminlink'] = '';
if ($down['isadmin'] == true)
{
	$down['adminlink'] = '[ <a href="' . XOOPS_URL . "/modules/$mydirname/admin/index.php?op=Download&lid=" . $down_arr['lid'] . '">' . _MD_PDD_EDIT . '</a> | ';
	$down['adminlink'] .= '<a href="' . XOOPS_URL . "/modules/$mydirname/admin/index.php?op=delDownload&lid=" . $down_arr['lid'] . '">' . _MD_PDD_DELETE . '</a> ]';
}
$votestring = ($down_arr['votes'] == 1) ? _MD_PDD_ONEVOTE : sprintf(_MD_PDD_NUMVOTES, $down_arr['votes']);
if (is_object($xoopsUser) && $down['isadmin'] != true)
{
	$down['useradminlink'] = ($xoopsUser->getvar('uid') == $down_arr['submitter']) ? true : false;
}

$modhandler = &xoops_gethandler('module');
$xoopsforumModule = &$modhandler->getByDirname("newbb");
if (is_object($xoopsforumModule) && $xoopsforumModule->getVar('isactive'))
{
	$down['forumid'] = ($down_arr['forumid'] > 0) ? $down_arr['forumid'] : 0;
}

$down['icons'] = PDd_displayicons($down_arr['published'], $down_arr['status'], $down_arr['hits']);
$xoopsTpl->append('file', $down);

?>