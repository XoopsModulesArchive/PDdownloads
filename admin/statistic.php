<?php
/**
 * $Id: statistic.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

function GetStats($limit)
{
	global $xoopsDB;

	if (empty($mydirname)){
		include '../include/mydirname.php';
	}

	$tbls=$xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads");
	$tblt=$xoopsDB->prefix("PDdownloads{$mydirnumber}_cat");

	$ret2=array();
	$sql="SELECT count(s.lid) as cpt, s.cid, t.title FROM $tbls s, $tblt t WHERE s.cid=t.cid GROUP BY s.cid ORDER BY t.title";
	$result = $xoopsDB->query($sql);
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['cid']]=$myrow;
	}
	$ret['dlspercad']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT sum(hits) as cpt, cid FROM $tbls GROUP BY cid ORDER BY cid";
	$result = $xoopsDB->query($sql);
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['cid']]=$myrow['cpt'];
	}
	$ret['callspercat']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT count(lid) as cpt, cid FROM $tbls WHERE expired!=0 GROUP BY cid ORDER BY cid";
	$result = $xoopsDB->query($sql);
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['cid']]=$myrow['cpt'];
	}
	$ret['expiredpercat']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT Count(Distinct(submitter)) as cpt, cid FROM $tbls GROUP BY cid ORDER BY cid";
	$result = $xoopsDB->query($sql);
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['cid']]=$myrow['cpt'];
	}
	$ret['createrpercat']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT s.lid, s.submitter, s.title, s.hits, s.cid FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.hits DESC";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result)) {
		$ret2[$myrow['lid']]=$myrow;
	}
	$ret['mostcalleddls']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT s.lid, s.submitter, s.title, s.hits, s.cid  FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.hits";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['lid']]=$myrow;
	}
	$ret['lesscalleddls']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT s.lid, s.submitter, s.title, s.rating, s.cid  FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.rating DESC";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['lid']]=$myrow;
	}
	$ret['bestrateddls']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT Sum(hits) as cpt, submitter FROM $tbls GROUP BY submitter ORDER BY cpt DESC";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['submitter']]=$myrow['cpt'];
	}
	$ret['mostcalledcreater']=$ret2;
	unset($ret2);

	$ret2=array();
	$sql="SELECT Avg(rating) as cpt, submitter FROM $tbls WHERE votes > 0 GROUP BY submitter ORDER BY cpt DESC";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['submitter']]=$myrow['cpt'];
	}
	$ret['bestratedcreater']=$ret2;
	unset($ret2);
	
	$ret2=array();
	$sql="SELECT Count(*) as cpt, submitter FROM $tbls GROUP BY submitter ORDER BY cpt DESC";
	$result = $xoopsDB->query($sql,intval($limit));
	while ($myrow = $xoopsDB->fetchArray($result) ) {
		$ret2[$myrow['submitter']]=$myrow['cpt'];
	}
	$ret['biggestcontributors']=$ret2;
	unset($ret2);

	return $ret;
}

function getCatTitle($limit)
{
	global $xoopsDB;

	if (empty($mydirname)){
		include '../include/mydirname.php';
	}

	$tbls=$xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads");
	$tblt=$xoopsDB->prefix("PDdownloads{$mydirnumber}_cat");

	$ret2=array();
	$i=0; $a=0;
	$sql="SELECT t.title FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.hits DESC";
	$result = $xoopsDB->query($sql, intval($limit));
	while ($myrow = $xoopsDB->fetchRow($result)) {
		$ret3[$a][$i]=$myrow;
		$i++;
	}
	unset($ret2, $i);

	$a++; $i=0;
	$ret2=array();
	$sql="SELECT t.title  FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.hits";
	$result = $xoopsDB->query($sql, intval($limit));
	while ($myrow = $xoopsDB->fetchRow($result)) {
		$ret3[$a][$i]=$myrow;
		$i++;
	}
	unset($ret2, $i);

	$a++; $i=0;
	$ret2=array();
	$sql="SELECT t.title  FROM $tbls s, $tblt t WHERE s.cid=t.cid ORDER BY s.rating DESC";
	$result = $xoopsDB->query($sql, intval($limit));
	while ($myrow = $xoopsDB->fetchRow($result)) {
		$ret3[$a][$i]=$myrow;
		$i++;
	}
	unset($ret2, $i);

	return $ret3;
}

global $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
xoops_cp_header();

PDd_adminmenu(7);
$stats = array();
$stats=GetStats($xoopsModuleConfig['admin_perpage']);
$statTitle=getCatTitle($xoopsModuleConfig['admin_perpage']);
$totals=array(0,0,0,0,0);

$dlspercad=$stats['dlspercad'];
$callspercat=$stats['callspercat'];
$expiredpercat=$stats['expiredpercat'];
$createrpercat=$stats['createrpercat'];
$class='';

echo "<div style='text-align: center;'><b>"._AM_PDD_MCATEGORY." " ._AM_PDD_STATISTIC ."</b><br />\n";
echo "<table border='1' width='100%'><tr class='bg3'><td align='center'>"._AM_PDD_MCATEGORY."</td><td align='center'>" . _AM_PDD_ENTRIES . "</td><td>" . _AM_PDD_VIEW . "</td><td>". _AM_PDD_EXPIRED."</td><td>"._AM_PDD_USENDFROM."</td></tr>";
foreach ( $dlspercad as $cid => $data ) {
	$url=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/viewcat.php?cid=" . $cid;
	$views=0;
	if(array_key_exists($cid,$callspercat)) {
		$views=$callspercat[$cid];
	}
	$expired=0;
	if(array_key_exists($cid,$expiredpercat)) {
		$expired=$expiredpercat[$cid];
	}
	$authors=0;
	if(array_key_exists($cid,$createrpercat)) {
		$authors=$createrpercat[$cid];
	}
	$articles=$data['cpt'];

	$totals[0]+=$articles;
	$totals[1]+=$views;
	$totals[3]+=$expired;
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='right'>%u</td><td align='right'>%u</td><td align='right'>%u</td><td align='right'>%u</td></tr>\n",$url,$myts->displayTarea($data['title']),$articles,$views,$expired,$authors);
}
$class = ($class == 'even') ? 'odd' : 'even';
printf("<tr class='".$class."'><td align='center'><b>%s</b></td><td align='right'><b>%u</b></td><td align='right'><b>%u</b></td><td align='right'><b>%u</b></td><td>&nbsp;</td>\n",_AM_PDD_TOTAL,$totals[0],$totals[1],$totals[3]);
echo "</table></div><br /><br /><br />";

$mostcalleddls=$stats['mostcalleddls'];
$catTitle=$statTitle;
$i = 0;
echo "<div style='text-align: center;'><b>" . _AM_PDD_DLSTAT . "</b><br /><br />" . _AM_PDD_DLSTAT1 . "<br />\n";
echo "<table border='1' width='100%'><tr class='bg3'><td align='center'>"._AM_PDD_MCATEGORY."</td><td align='center'>" . _AM_PDD_MINDEX_TITLE . "</td><td>" . _AM_PDD_MINDEX_POSTER . "</td><td>" . _AM_PDD_VIEW . "</td></tr>\n";
foreach ( $mostcalleddls as $lid => $data ) {
	$url1=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/viewcat.php?cid=" . $data['cid'];
	$url2=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/singlefile.php?cid=". $data['cid']. '&lid=' .$lid;
	$url3=XOOPS_URL . '/userinfo.php?uid=' . $data['submitter'];
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='left'><a href='%s' target='_blank'>%s</a></td><td><a href='%s' target='_blank'>%s</a></td><td align='right'>%u</td></tr>\n",$url1,$catTitle[0][$i][0],$url2,$myts->displayTarea($data['title']),$url3,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($data['submitter'])),$data['hits']);$i++;
}
echo "</table>";
unset($i);

$i = 0;
$lesscalleddls=$stats['lesscalleddls'];
echo '<br /><br />'._AM_PDD_DLSTAT2;
echo "<table border='1' width='100%'><tr class='bg3'><td align='center'>"._AM_PDD_MCATEGORY."</td><td align='center'>" . _AM_PDD_MINDEX_TITLE . "</td><td>" . _AM_PDD_MINDEX_POSTER . "</td><td>" . _AM_PDD_VIEW . "</td></tr>\n";
foreach ( $lesscalleddls as $lid => $data ) {
	$url1=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/viewcat.php?cid=" . $data['cid'];
	$url2=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/singlefile.php?cid=". $data['cid']. '&lid=' .$lid;
	$url3=XOOPS_URL . '/userinfo.php?uid=' . $data['submitter'];
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='left'><a href='%s' target='_blank'>%s</a></td><td><a href='%s' target='_blank'>%s</a></td><td align='right'>%u</td></tr>\n",$url1,$catTitle[1][$i][0],$url2,$myts->displayTarea($data['title']),$url3,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($data['submitter'])),$data['hits']);$i++;
}
echo "</table>";
unset($i);

$i = 0;
$bestrateddls=$stats['bestrateddls'];
echo '<br /><br />'._AM_PDD_DLSTAT3;
echo "<table border='1' width='100%'><tr class='bg3'><td align='center'>"._AM_PDD_MCATEGORY."</td><td align='center'>" . _AM_PDD_MINDEX_TITLE . "</td><td>" . _AM_PDD_MINDEX_POSTER . "</td><td>" . _AM_PDD_VOTE_RATING . "</td></tr>\n";
foreach ( $bestrateddls as $lid => $data ) {
	$url1=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/viewcat.php?cid=" . $data['cid'];
	$url2=XOOPS_URL . "/modules/" . $xoopsModule -> dirname() . "/singlefile.php?cid=". $data['cid']. '&lid=' .$lid;
	$url3=XOOPS_URL . '/userinfo.php?uid=' . $data['submitter'];
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='left'><a href='%s' target='_blank'>%s</a></td><td><a href='%s' target='_blank'>%s</a></td><td align='right'>%s</td></tr>\n",$url1,$catTitle[2][$i][0],$url2,$myts->displayTarea($data['title']),$url3,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($data['submitter'])),number_format($data['rating'], 2));$i++;
}
echo "</table></div><br /><br /><br />";
unset($i);

$mostcalledcreater=$stats['mostcalledcreater'];
echo "<div style='text-align: center;'><b>" . _AM_PDD_CREATERSTAT . "</b><br /><br />" . _AM_PDD_CREATERSTAT1 . "<br />\n";
echo "<table border='1' width='100%'><tr class='bg3'><td>"._AM_PDD_MINDEX_POSTER."</td><td>" . _AM_PDD_VIEW . "</td></tr>\n";
foreach ( $mostcalledcreater as $submitter => $reads) {
	$url=XOOPS_URL . '/userinfo.php?uid=' . $submitter;
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='right'>%u</td></tr>\n",$url,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($submitter)),$reads);
}
echo "</table>";

$bestratedcreater=$stats['bestratedcreater'];
echo '<br /><br />'._AM_PDD_CREATERSTAT2;
echo "<table border='1' width='100%'><tr class='bg3'><td>"._AM_PDD_MINDEX_POSTER."</td><td>" . _AM_PDD_VOTE_RATING . "</td></tr>\n";
foreach ( $bestratedcreater as $submitter => $rating) {
	$url=XOOPS_URL . '/userinfo.php?uid=' . $submitter;
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='right'>%u</td></tr>\n",$url,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($submitter)),$rating);
}
echo "</table>";

$biggestcontributors=$stats['biggestcontributors'];
echo '<br /><br />'._AM_PDD_CREATERSTAT3;
echo "<table border='1' width='100%'><tr class='bg3'><td>"._AM_PDD_MINDEX_POSTER."</td><td>" . _AM_PDD_CREATERSTAT4 . "</td></tr>\n";
foreach ( $biggestcontributors as $submitter => $count) {
	$url=XOOPS_URL . '/userinfo.php?uid=' . $submitter;
	$class = ($class == 'even') ? 'odd' : 'even';
	printf("<tr class='".$class."'><td align='left'><a href='%s' target ='_blank'>%s</a></td><td align='right'>%u</td></tr>\n",$url,$myts->htmlSpecialChars(XoopsUser::getUnameFromId($submitter)),$count);
}
echo "</table></div><br />";
xoops_cp_footer();
?>