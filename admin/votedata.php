<?php
/**
 * $Id: votedata.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';

$op = "";
if (isset($_POST))
{
	foreach ($_POST as $k => $v)
	{
		${$k} = $v;
	}
}

if (isset($_GET))
{
	foreach ($_GET as $k => $v)
	{
		${$k} = $v;
	}
}

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op)
{
	case "delVote":
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check(true, $_REQUEST['t'])) {
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}
	global $xoopsDB, $_GET;
	$rid = $_GET['rid'];
	$lid = $_GET['lid'];
	$xoopsDB->queryF("DELETE FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE ratingid = $rid");
	PDd_updaterating($lid);
	redirect_header("votedata.php", 1, _AM_PDD_VOTEDELETED);
	break;

	case 'main':
	default:

	global $xoopsDB, $imagearray;

	$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
	$useravgrating = '0';
	$uservotes = '0';

	$sql = "SELECT * FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_votedata") . " ORDER BY ratingtimestamp DESC";
	$results = $xoopsDB->query($sql, 20, $start);
	$votes = $xoopsDB->getRowsNum($results);

	$sql = "SELECT rating FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_votedata") . "";
	$result2 = $xoopsDB->query($sql);
	$uservotes = $xoopsDB->getRowsNum($result2);
	$useravgrating = 0;

	while (list($rating2) = $xoopsDB->fetchRow($result2))
	{
		$useravgrating = $useravgrating + $rating2;
	}
	if ($useravgrating > 0)
	{
		$useravgrating = $useravgrating / $uservotes;
		$useravgrating = number_format($useravgrating, 2);
	}

	xoops_cp_header();
	PDd_adminmenu(6);

	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_VOTE_DISPLAYVOTES . "</legend>\n
		<div style='padding: 8px;'>\n
		<div><b>" . _AM_PDD_VOTE_USERAVG . ": </b>$useravgrating</div>\n
		<div><b>" . _AM_PDD_VOTE_TOTALRATE . ": </b>$uservotes</div>\n
		<div style='padding: 8px;'>\n
		<li>" . $imagearray['deleteimg'] . " " . _AM_PDD_VOTE_DELETEDSC . "</li>
		<div>\n
		</fieldset>\n
		<br />\n

		<table width='100%' cellspacing='1' cellpadding='2' class='outer'>\n
		<tr>\n
		<th align='center'>" . _AM_PDD_VOTE_ID . "</th>\n
		<th align='center'>" . _AM_PDD_VOTE_USER . "</th>\n
		<th align='center'>" . _AM_PDD_VOTE_IP . "</th>\n
		<th align='center'>" . _AM_PDD_VOTE_FILETITLE . "</th>\n
		<th align='center'>" . _AM_PDD_VOTE_RATING . "</th>\n
		<th align='center'>" . _AM_PDD_VOTE_DATE . "</th>\n
		<th align='center'>" . _AM_PDD_MINDEX_ACTION . "</th></tr>\n";

	if ($votes == 0)
		echo "<tr><td align='center' colspan='7' class='head'>" . _AM_PDD_VOTE_NOVOTES . "</td></tr>";

	while (list($ratingid, $lid, $ratinguser, $rating, $ratinghostname, $ratingtimestamp) = $xoopsDB->fetchRow($results))
	{
		$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid=" . $lid . "";
		$down_array = $xoopsDB->fetchArray($xoopsDB->query($sql));

		$formatted_date = formatTimestamp($ratingtimestamp, $xoopsModuleConfig['dateformat']);
		$ratinguname = XoopsUser::getUnameFromId($ratinguser);
		echo "
		<tr>\n
		<td class='head' align='center'>$ratingid</td>\n
		<td class='even' align='center'>$ratinguname</td>\n
		<td class='even' align='center' >$ratinghostname</td>\n
		<td class='even' align='center'>".$down_array['title']."</td>\n
		<td class='even' align='center'>$rating</td>\n
		<td class='even' align='center'>$formatted_date</td>\n
		<td class='even' align='center'><b><a href='votedata.php?op=delVote&lid=$lid&rid=$ratingid&t=".$GLOBALS['xoopsSecurity']->createToken()."'>".$imagearray['deleteimg']."</a></b></td>\n
		</tr>\n";
	}
	echo "</table>";
	//Include page navigation
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
	$page = ($uservotes > 20) ? _AM_PDD_MINDEX_PAGE : '';
	$pagenav = new XoopsPageNav($uservotes, 20, $start, 'start');
	echo '<div align="right" style="padding: 8px;">' . $page . '' . $pagenav->renderImageNav() . '</div>';
	break;
}
xoops_cp_footer();

?>