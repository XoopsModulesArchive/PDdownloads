<?php
/**
 * $Id: functions.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include "mydirname.php";

$mytree = new XoopsTree($xoopsDB->prefix("PDdownloads{$mydirnumber}_cat"), "cid", "pid");

function checkentry ($id, $groups, $module_id, $what=0)
{
	global $xoopsDB;

	if (empty($mydirname))
	include 'mydirname.php';

	$gperm_handler = &xoops_gethandler('groupperm');

	if ($what == 0)
	{
		$result = $xoopsDB->query("SELECT cid FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid = $id");
		if ($xoopsDB->getRowsNum($result > 0 && !$gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $id, $groups, $module_id)))
		{
			redirect_header("index.php", 3, _NOPERM);
			exit();
		}
		else if ($result == 0)
		{
			redirect_header("index.php", 1, _MD_PDD_NOCAT);
			exit();
		}
	}

	else if ($what == 1)
	{
		$result = $xoopsDB->query("SELECT lid FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $id");
		if ($xoopsDB->getRowsNum($result) > 0)
		{
			redirect_header("index.php", 3,_NOPERM);
			exit();
		}
		else
		{
			redirect_header("index.php", 1, _MD_PDD_NODOWNLOAD);
			exit();
		}
	}
}

function SearchModule($name)
{
	global $xoopsDB;

	$sql = $xoopsDB->query("SELECT count(*) FROM ".$xoopsDB -> prefix('modules')." WHERE dirname = '".$name."' AND isactive=1");
	list($numrows)=$xoopsDB->fetchRow($sql);
	if ($numrows > 0) return true;
}

function getInfosfromModule($foldername, $whatinfo)
{
	$modhandler = & xoops_gethandler('module');
	$Module = & $modhandler -> getByDirname($foldername);
	$modulename = $Module -> getVar($whatinfo);

	return $modulename;
}

function PDd_save_Permissions($groups, $id, $perm_name)
{
	if (empty($mydirname)){
		include 'mydirname.php';
	}
	$result = true;
	$hModule = & xoops_gethandler('module');
	$PDdModule = & $hModule -> getByDirname($mydirname);

	$module_id = $PDdModule -> getVar('mid');
	$gperm_handler = & xoops_gethandler('groupperm');

	/*
	* First, if the permissions are already there, delete them
	*/
	$gperm_handler -> deleteByModule($module_id, $perm_name, $id);
	/*
	*  Save the new permissions
	*/
	if (is_array($groups))
	{
		foreach ($groups as $group_id)
		{
			$gperm_handler -> addRight($perm_name, $id, $group_id, $module_id);
		}
	}
	return $result;
}

/**
 * toolbar()
 *
 * @return
 **/
function PDd_toolbar()
{
	global $xoopsModuleConfig, $xoopsUser, $xoopsDLModule;
	$toolbar = "[ ";
	if ($xoopsUser && array_intersect($xoopsModuleConfig['submitarts'], $xoopsUser->getGroups()) || !$xoopsUser && isset($xoopsModuleConfig['anonpost']) && $xoopsModuleConfig['anonpost'] == 1)
	$toolbar .= "<a href='submit.php'>" . _MD_PDD_SUBMITDOWNLOAD . "</a> | ";
	if ($xoopsUser)
	$toolbar .= "<a href='viewcat.php?uid=".$xoopsUser->getVar('uid')."'>" . _MI_PDD_SMNAME4 . "</a> | ";
	$toolbar .= "<a href='newlist.php'>" . _MD_PDD_LATESTLIST . "</a> | <a href='topten.php?list=hit'>" . _MD_PDD_POPULARITY . "</a> | <a href='topten.php?list=rate'>" . _MD_PDD_TOPRATED . "</a> ]";
	return $toolbar;
}

/**
 * PDd_serverstats()
 *
 * @return
 **/
function PDd_serverstats()
{
	global $xoopsModuleConfig, $xoopsDB, $xoopsModule;

	if (empty($mydirname)){
		include 'mydirname.php';
	}

	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_DOWN_IMAGEINFO . "</legend>\n
		<div style='padding: 8px;'>\n
		<div>" . _AM_PDD_DOWN_SPHPINI . "</div>\n
		";

	$safemode = (ini_get('safe_mode')) ? _AM_PDD_DOWN_ON . _AM_PDD_DOWN_SAFEMODEPROBLEMS : _AM_PDD_DOWN_OFF;
	$registerglobals = (ini_get('register_globals') == '') ? _AM_PDD_DOWN_OFF : _AM_PDD_DOWN_ON;
	$downloads = (ini_get('file_uploads')) ? _AM_PDD_DOWN_ON : _AM_PDD_DOWN_OFF;

	$gdlib = (function_exists('gd_info')) ? _AM_PDD_DOWN_GDON : _AM_PDD_DOWN_GDOFF;
	echo "<li>" . _AM_PDD_DOWN_GDLIBSTATUS . $gdlib;
	if (function_exists('gd_info') && true == $gdlib = gd_info())
	{
		echo "<li>" . _AM_PDD_DOWN_GDLIBVERSION . "<b>" . $gdlib['GD Version'] . "</b>";
	}

	$postsize = ini_get('post_max_size');
	$uploadsize = ini_get('upload_max_filesize');

	if (PDd_PrettySize(intval($xoopsModuleConfig['maxfilesize'])*1024) > (integer) $uploadsize)
	{
		$xoopsDB -> queryF("UPDATE " . $xoopsDB -> prefix("config") . " SET conf_value = ".intval($uploadsize*1024)."  WHERE conf_name=\"maxfilesize\" AND conf_modid=".$xoopsModule -> getVar('mid')."");
	}

	echo "<br /><br />\n\n";
	echo "<li>" . _AM_PDD_DOWN_SAFEMODESTATUS . $safemode;
	echo "<li>" . _AM_PDD_DOWN_REGISTERGLOBALS . $registerglobals;
	echo "<li>" . _AM_PDD_DOWN_SERVERUPLOADSTATUS . $downloads;
	echo "<li>" . _AM_PDD_DOWN_MAXUPLOADSIZE . " <b>$uploadsize</b>\n";
	echo "<li>" . _AM_PDD_DOWN_MAXPOSTSIZE . " <b>$postsize</b>\n";
	echo "<li>" . _AM_PDD_DOWN_MAXEXECTIME . " <b>".ini_get('max_execution_time')." s</b>\n";
	echo "</div>";
	echo "</fieldset><br />";
}

/**
 * displayicons()
 *
 * @param  $time
 * @param integer $status
 * @param integer $counter
 * @return
 */
function PDd_displayicons($time, $status = 0, $counter = 0)
{
	if (empty($mydirname)){
		include 'mydirname.php';
	}
	global $xoopsModuleConfig;

	$new = '';
	$pop = '';

	$newdate = (time() - (86400 * intval($xoopsModuleConfig['daysnew'])));
	$popdate = (time() - (86400 * intval($xoopsModuleConfig['daysupdated']))) ;

	if ($xoopsModuleConfig['displayicons'] != 3)
	{
		if ($newdate < $time)
		{
			if (intval($status) > 1)
			{
				if ($xoopsModuleConfig['displayicons'] == 1)
				$new = "&nbsp;<img src=" . XOOPS_URL . "/modules/$mydirname/images/icon/update.gif alt='' align ='absmiddle'/>";
				if ($xoopsModuleConfig['displayicons'] == 2)
				$new = "<i>Updated!</i>";
			}
			else
			{
				if ($xoopsModuleConfig['displayicons'] == 1)
				$new = "&nbsp;<img src=" . XOOPS_URL . "/modules/$mydirname/images/icon/newred.gif alt='' align ='absmiddle'/>";
				if ($xoopsModuleConfig['displayicons'] == 2)
				$new = "<i>New!</i>";
			}
		}
		if ($popdate < $time)
		{
			if ($counter >= $xoopsModuleConfig['popular'])
			{
				if ($xoopsModuleConfig['displayicons'] == 1)
				$pop = "&nbsp;<img src =" . XOOPS_URL . "/modules/$mydirname/images/icon/pop.gif alt='' align ='absmiddle'/>";
				if ($xoopsModuleConfig['displayicons'] == 2)
				$pop = "<i>Popular</i>";
			}
		}
	}
	$icons = $new . " " . $pop;
	return $icons;
}

if (!function_exists('convertorderbyin'))
{
	// Reusable Link Sorting Functions
	/**
     * convertorderbyin()
     *
     * @param $orderby
     * @return
     **/
	function convertorderbyin($orderby)
	{
		switch (trim($orderby))
		{
			case "titleA":
			$orderby = "title ASC";
			break;
			case "dateA":
			$orderby = "published ASC";
			break;
			case "hitsA":
			$orderby = "hits ASC";
			break;
			case "ratingA":
			$orderby = "rating ASC";
			break;
			case "titleD":
			$orderby = "title DESC";
			break;
			case "hitsD":
			$orderby = "hits DESC";
			break;
			case "ratingD":
			$orderby = "rating DESC";
			break;
			case"dateD":
			$orderby = "published DESC";
			break;
		}
		return $orderby;
	}
}
if (!function_exists('convertorderbytrans'))
{
	function convertorderbytrans($orderby)
	{
		if ($orderby == "hits ASC") $orderbyTrans = _MD_PDD_POPULARITYLTOM;
		if ($orderby == "hits DESC") $orderbyTrans = _MD_PDD_POPULARITYMTOL;
		if ($orderby == "title ASC") $orderbyTrans = _MD_PDD_TITLEATOZ;
		if ($orderby == "title DESC") $orderbyTrans = _MD_PDD_TITLEZTOA;
		if ($orderby == "published ASC") $orderbyTrans = _MD_PDD_DATEOLD;
		if ($orderby == "published DESC") $orderbyTrans = _MD_PDD_DATENEW;
		if ($orderby == "rating ASC") $orderbyTrans = _MD_PDD_RATINGLTOH;
		if ($orderby == "rating DESC") $orderbyTrans = _MD_PDD_RATINGHTOL;
		return $orderbyTrans;
	}
}
if (!function_exists('convertorderbyout'))
{
	function convertorderbyout($orderby)
	{
		if ($orderby == "title ASC") $orderby = "titleA";
		if ($orderby == "published ASC") $orderby = "dateA";
		if ($orderby == "hits ASC") $orderby = "hitsA";
		if ($orderby == "rating ASC") $orderby = "ratingA";
		if ($orderby == "title DESC") $orderby = "titleD";
		if ($orderby == "published DESC") $orderby = "dateD";
		if ($orderby == "hits DESC") $orderby = "hitsD";
		if ($orderby == "rating DESC") $orderby = "ratingD";
		return $orderby;
	}
}

/**
 * PrettySize()
 *
 * @param $size
 * @return
 **/
function PDd_PrettySize($size)
{
	$mb = 1024 * 1024;
	if ($size > $mb)
	{
		$mysize = sprintf ("%01.2f", $size / $mb) . " MB";
	}
	elseif ($size >= 1024)
	{
		$mysize = sprintf ("%01.2f", $size / 1024) . " KB";
	}
	else
	{
		$mysize = sprintf(_MD_PDD_NUMBYTES, $size);
	}
	return $mysize;
}

/**
 * updaterating()
 *
 * @param $sel_id
 * @return updates rating data in itemtable for a given item
 **/
function PDd_updaterating($sel_id)
{
	if (empty($mydirname)){
		include 'mydirname.php';
	}
	global $xoopsDB;
	$voteresult = $xoopsDB -> query("select rating FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_votedata") . " WHERE lid = $sel_id");
	$votesDB = $xoopsDB -> getRowsNum($voteresult);
	$totalrating = 0;
	while (list($rating) = $xoopsDB -> fetchRow($voteresult))
	{
		$totalrating += $rating;
	}
	$finalrating = $totalrating / $votesDB;
	$finalrating = number_format($finalrating, 4);
	$xoopsDB->queryF("UPDATE " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . " SET rating = $finalrating, votes = $votesDB WHERE lid = $sel_id");
}


/**
 * totalcategory()
 *
 * @param integer $pid
 * @return
 **/
function PDd_totalcategory($pid = 0)
{
	global $xoopsDB, $xoopsModule, $xoopsUser;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$groups = (is_object($xoopsUser)) ? $xoopsUser -> getGroups() : XOOPS_GROUP_ANONYMOUS;
	$gperm_handler = & xoops_gethandler('groupperm');

	$sql = "SELECT a.cid, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.cid = b.gperm_itemid AND b.gperm_modid = '".$xoopsModule -> getVar('mid')."' AND b.gperm_name = \"PDDownCatPerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]";
	if ($pid > 0)
	{
		$sql .= "WHERE pid = 0";
	}
	$result = $xoopsDB -> query($sql);

	return $xoopsDB->getRowsNum($result);
}

/**
 * getTotalItems()
 *
 * @param integer $sel_id
 * @param integer $get_child
 * @return the total number of items in items table that are accociated with a given table $table id
 **/
function PDd_getTotalItems($sel_id = 0, $get_child = 0)
{
	global $xoopsDB, $mytree, $xoopsModule, $xoopsUser;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$groups = (is_object($xoopsUser)) ? $xoopsUser -> getGroups() : XOOPS_GROUP_ANONYMOUS;
	$gperm_handler = & xoops_gethandler('groupperm');

	$count = 0;
	$published_date = 0;
	$time_cur = time();
	$arr = array();

	$query = "SELECT a.lid, a.published, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE
	a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = '".$xoopsModule -> getVar('mid')."' AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]";
	if ($sel_id)
	{
		$query .= " AND cid=" . $sel_id . "";
	}
	$result = $xoopsDB -> query($query);
	while (list($lid, $published) = $xoopsDB -> fetchRow($result))
	{
		$count++;
		$published_date = ($published > $published_date) ? $published : $published_date;
	}

	$thing = 0;
	if ($get_child == 1)
	{
		$arr = $mytree -> getAllChildId($sel_id);
		$size = count($arr);
		for($i = 0;$i < count($arr);$i++)
		{
			$query2 = "SELECT a.lid, a.published, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= " . $time_cur . ") AND (a.expired = 0 OR a.expired > " . $time_cur . ") AND b.gperm_modid = '".$xoopsModule -> getVar('mid')."' AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] AND cid=" . $arr[$i] . "";
			$result2 = $xoopsDB -> query($query2);
			$result2 = $xoopsDB -> query($query2);
			while (list($lid, $published) = $xoopsDB -> fetchRow($result2))
			{
				$thing++;
				$published_date = ($published > $published_date) ? $published : $published_date;
			}
		}
	}
	$info['count'] = $count + $thing;
	$info['published'] = $published_date;
	return $info;
}

function PDd_imageheader()
{
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$image = '';
	$result = $xoopsDB -> query("SELECT indeximage, indexheading FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_indexpage") . " ");
	list($indeximage, $indexheading) = $xoopsDB -> fetchrow($result);
	if (!empty($indeximage))
	{
		$image = PDd_displayimage($indeximage, "'index.php'", $xoopsModuleConfig['mainimagedir'], $indexheading);
	}
	return $image;
}

function PDd_displayimage($image = '', $path = '', $imgsource = '', $alttext = '')
{
	global $xoopsConfig, $xoopsUser, $xoopsModule;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$showimage = '';

	/**
     * Check to see if link is given
     */
	if ($path)
	{
		$showimage = "<a href=" . $path . ">";
	}

	/**
     * checks to see if the file is valid else displays default blank image
     */

	if (!is_dir(XOOPS_ROOT_PATH . "/" . $imgsource . "/" . $image) && file_exists(XOOPS_ROOT_PATH . "/" . $imgsource . "/" . $image))
	{
		$showimage .= "<img src='" . XOOPS_URL . "/" . $imgsource . "/" . $image . "' border='0' alt='" . $alttext . "' /></a>";
	}
	else
	{
		if ($xoopsUser && $xoopsUser -> isAdmin($xoopsModule -> mid()))
		{
			$showimage .= "<img src='" . XOOPS_URL . "/modules/$mydirname/images/brokenimg.png' alt='" . _MD_PDD_ISADMINNOTICE . "' /></a>";
		}
		else
		{
			$showimage .= "<img src='" . XOOPS_URL . "/modules/$mydirname/images/blank.png' alt=" . $alttext . " /></a>";
		}
	}
	clearstatcache();
	return $showimage;
}

/**
 * down_createthumb()
 *
 * @param $img_name
 * @param $img_path
 * @param $img_savepath
 * @param integer $img_w
 * @param integer $img_h
 * @param integer $quality
 * @param integer $update
 * @param integer $aspect
 * @return
 **/
function down_createthumb($img_name, $img_path, $img_savepath, $img_w = 100, $img_h = 100, $quality = 100, $update = 0, $aspect = 1)
{
	global $xoopsModuleConfig, $xoopsConfig;
	// paths
	if ($xoopsModuleConfig['usethumbs'] == 0)
	{
		$image_path = XOOPS_URL . "/{$img_path}/{$img_name}";
		return $image_path;
	}
	$image_path = XOOPS_ROOT_PATH . "/{$img_path}/{$img_name}";

	$savefile = $img_path . "/" . $img_savepath . "/" . $img_w . "x" . $img_h . "_" . $img_name;
	$savepath = XOOPS_ROOT_PATH . "/" . $savefile;
	// Return the image if no update and image exists
	if ($update == 0 && file_exists($savepath))
	{
		return XOOPS_URL . "/" . $savefile;
	}

	list($width, $height, $type, $attr) = getimagesize($image_path, $info);

	switch ($type)
	{
		case 1:
		# GIF image
		if (function_exists('imagecreatefromgif'))
		{
			$img = @imagecreatefromgif($image_path);
		}
		else
		{
			$img = @imageCreateFromPNG($image_path);
		}
		break;
		case 2:
		# JPEG image
		$img = @imageCreateFromJPEG($image_path);
		break;
		case 3:
		# PNG image
		$img = @imageCreateFromPNG($image_path);
		break;
		default:
		return $image_path;
		break;
	}

	if (!empty($img))
	{
		/**
         * Get image size and scale ratio
         */
		$scale = min($img_w / $width, $img_h / $height);
		/**
         * If the image is larger than the max shrink it
         */
		if ($scale < 1 && $aspect == 1)
		{
			$img_w = floor($scale * $width);
			$img_h = floor($scale * $height);
		}
		/**
         * Create a new temporary image
         */
		if (function_exists('imagecreatetruecolor'))
		{
			$tmp_img = imagecreatetruecolor($img_w, $img_h);
		}
		else
		{
			$tmp_img = imagecreate($img_w, $img_h);
		}
		/**
         * Copy and resize old image into new image
         */
		ImageCopyResampled($tmp_img, $img, 0, 0, 0, 0, $img_w, $img_h, $width, $height);
		imagedestroy($img);
		flush();
		$img = $tmp_img;
	}

	switch ($type)
	{
		case 1:
		default:
		# GIF image
		if (function_exists('imagegif'))
		{
			imagegif($img, $savepath);
		}
		else
		{
			imagePNG($img, $savepath);
		}
		break;
		case 2:
		# JPEG image
		imageJPEG($img, $savepath, $quality);
		break;
		case 3:
		# PNG image
		imagePNG($img, $savepath);
		break;
	}
	imagedestroy($img);
	flush();
	return XOOPS_URL . "/" . $savefile;
}

function PDd_letters()
{
	global $xoopsModule;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$letterchoice = "<div>" . _MD_PDD_BROWSETOTOPIC . "</div>";
	$letterchoice .= "[  ";
	$alphabet = PDd_getLetters();
	$num = count($alphabet) - 1;
	$counter = 0;
	while (list(, $ltr) = each($alphabet))
	{
		$letterchoice .= "<a href='" . XOOPS_URL . "/modules/$mydirname/viewcat.php?list=$ltr'>$ltr</a>";
		if ($counter == round($num / 2))
		$letterchoice .= " ]<br />[ ";
		elseif ($counter != $num)
		$letterchoice .= "&nbsp;|&nbsp;";
		$counter++;
	}
	$letterchoice .= " ]";
	return $letterchoice;
}

function PDd_getLetters()
{
	return array ("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
}

function PDd_isnewimage($published)
{
	global $xoopsDB;

	$oneday = (time() - (86400 * 1));
	$threedays = (time() - (86400 * 3));
	$week = (time() - (86400 * 7));

	if ($published > 0 && $published < $week)
	{
		$indicator['image'] = "images/icon/download4.gif";
		$indicator['alttext'] = _MD_PDD_NEWLAST;
	} elseif ($published >= $week && $published < $threedays)
	{
		$indicator['image'] = "images/icon/download3.gif";
		$indicator['alttext'] = _MD_PDD_NEWTHIS;
	} elseif ($published >= $threedays && $published < $oneday)
	{
		$indicator['image'] = "images/icon/download2.gif";
		$indicator['alttext'] = _MD_PDD_THREE;
	} elseif ($published >= $oneday)
	{
		$indicator['image'] = "images/icon/download1.gif";
		$indicator['alttext'] = _MD_PDD_TODAY;
	}
	else
	{
		$indicator['image'] = "images/icon/download.gif";
		$indicator['alttext'] = _MD_PDD_NO_FILES;
	}
	return $indicator;
}
// GetDownloadTime()
// This function is used to show some different download times
// BCMATH-Support in PHP needed!
// (c)02.04.04 by St@neCold, stonecold@csgui.de, http://www.csgui.de
function PDd_GetDownloadTime($size = 0, $gmodem = 1, $gisdn = 1, $gdsl = 1, $gslan = 0, $gflan = 0)
{
	$aflag = array();
	$amtime = array();
	$artime = array();
	$ahtime = array();
	$asout = array();
	$aflag = array($gmodem, $gisdn, $gdsl, $gslan, $gflan);
	$amtime = array($size / 6300 / 60, $size / 7200 / 60, $size / 86400 / 60, $size / 1125000 / 60, $size / 11250000 / 60);
	$amname = array('Modem(56k)', 'ISDN(64k)', 'DSL(768k)', 'LAN(10M)', 'LAN(100M');
	for($i = 0;$i < 5;$i++)
	{
		$artime[$i] = ($amtime[$i] % 60);
	}
	for($i = 0;$i < 5;$i++)
	{
		$ahtime[$i] = sprintf(' %2.0f', $amtime[$i] / 60);
	}
	if ($size <= 0) $dltime = 'N/A';
	else
	{
		for($i = 0;$i < 5;$i++)
		{
			if (!$aflag[$i]) $asout[$i] = '';
			else
			{
				if (($amtime[$i] * 60) < 1) $asout[$i] = sprintf(' : %4.2fs', $amtime[$i] * 60);
				else
				{
					if ($amtime[$i] < 1) $asout[$i] = sprintf(' : %2.0fs', round($amtime[$i] * 60));
					else
					{
						if ($ahtime[$i] == 0) $asout[$i] = sprintf(' : %5.1fmin', $amtime[$i]);
						else $asout[$i] = sprintf(' : %2.0fh%2.0fmin', $ahtime[$i], $artime[$i]);
					}
				}
				$asout[$i] = "<b>" . $amname[$i] . "</b>" . $asout[$i];
				if ($i < 4) $asout[$i] = $asout[$i] . '|';
			}
		}
		$dltime = '';
		for($i = 0;$i < 5;$i++)
		{
			$dltime = $dltime . $asout[$i];
		}
	}
	return $dltime;
}

function PDd_strrrchr($haystack, $needle)
{
	return substr($haystack, 0, strpos($haystack, $needle) + 1);
}

function PDd_retmime($filename, $usertype = 1)
{
	global $xoopsDB;
	if (empty($mydirname)){
		include 'mydirname.php';
	}

	$ext = ltrim(strrchr($filename, '.'), '.');
	$sql = "SELECT mime_types, mime_ext FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_mimetypes") . " WHERE mime_ext = '" . strtolower($ext) . "'";
	if ($usertype == 1)
	$sql .= " AND mime_admin = 1";
	else
	$sql .= " AND mime_user = 1";
	$result = $xoopsDB -> query($sql);
	list($mime_types , $mime_ext) = $xoopsDB -> fetchrow($result);
	$mimtypes = explode(' ', trim($mime_types));
	return $mimtypes;
}

function PDd_adminmenu($currentoption = '', $breadcrumb = '')
{
	if (empty($mydirname)){
		include 'mydirname.php';
	}
	/* Nice buttons styles */
	echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/$mydirname/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/$mydirname/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/$mydirname/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
	global $xoopsModule, $xoopsConfig;

	$tblColors = array('','','','','','','','','');
	if($currentoption>=0) {
		$tblColors[$currentoption] = 'current';
	}

	echo "<div id='buttontop'>";
	echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a href='../../system/admin.php?fct=preferences&op=showmod&mod=" . $xoopsModule -> getVar('mid') . "'>" . _AM_PDD_PREFS . "</a> | <a href='permissions.php'>" . _AM_PDD_PERMISSIONS . "</a> | <a href='myblocksadmin.php'>" . _MI_PDD_BLOCKADMIN . "</a> | <a href='../index.php'>" . _AM_PDD_GOMODULE . "</a> | <a href='about.php'>" . _AM_PDD_ABOUT . "</a></td>";
	echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $xoopsModule->name() . "  " . _AM_PDD_MIME_ADMIN . "</b> " . $breadcrumb . "</td>";
	echo "</tr></table>";
	echo "</div>";

	echo "<div id='buttonbar'>";
	echo "<ul>";
	echo "<li id='" . $tblColors[0] . "'><a href=\"index.php\"\"><span>"._AM_PDD_BINDEX ."</span></a></li>\n";
	echo "<li id='" . $tblColors[1] . "'><a href=\"indexpage.php\"\"><span>"._AM_PDD_INDEXPAGE ."</span></a></li>\n";
	echo "<li id='" . $tblColors[2] . "'><a href=\"category.php\"><span>" . _AM_PDD_MCATEGORY . "</span></a></li>\n";
	echo "<li id='" . $tblColors[3] . "'><a href=\"index.php?op=Download\"><span>" . _AM_PDD_MDOWNLOADS . "</span></a></li>\n";
	echo "<li id='" . $tblColors[4] . "'><a href=\"upload.php\"><span>" . _AM_PDD_MUPLOADS . "</span></a></li>\n";
	echo "<li id='" . $tblColors[5] . "'><a href=\"mimetypes.php\"><span>" . _AM_PDD_MMIMETYPES . "</span></a></li>\n";
	echo "<li id='" . $tblColors[6] . "'><a href=\"votedata.php\"><span>" . _AM_PDD_MVOTEDATA . "</span></a></li>\n";
	echo "<li id='" . $tblColors[7] . "'><a href=\"statistic.php\"><span>" . _AM_PDD_STATISTIC . "</span></a></li>\n";
	echo "<li id='" . $tblColors[8] . "'><a href=\"uanditool.php\"><span>" . _AM_PDD_UANDITOOL . "</span></a></li>\n";
	echo "</ul></div>";
	echo "<br /><br /><pre>&nbsp;</pre><pre>&nbsp;</pre><pre>&nbsp;</pre>";
}

function PDd_getDirSelectOption($selected, $dirarray, $namearray)
{
	echo "<select size='1' name='workd' onchange='location.href=\"upload.php?rootpath=\"+this.options[this.selectedIndex].value'>";
	echo "<option value=''>--------------------------------------</option>";
	foreach($namearray as $namearray => $workd)
	{
		if ($workd === $selected)
		{
			$opt_selected = "selected";
		}
		else
		{
			$opt_selected = "";
		}
		echo "<option value='" . htmlspecialchars($namearray, ENT_QUOTES) . "' $opt_selected>" . $workd . "</option>";
	}
	echo "</select>";
}

function PDd_uploading($_FILES, $uploaddir = "uploads", $allowed_mimetypes = '', $redirecturl = "index.php", $num = 0, $redirect = 0, $usertype = 1, $where = 0)
{
	global $_FILES, $xoopsConfig, $xoopsModuleConfig, $_POST, $xoopsModule;

	$down = array();

	if (empty($mydirname))
	include 'mydirname.php';

	include_once XOOPS_ROOT_PATH . "/modules/$mydirname/class/uploader.php";

	if (empty($allowed_mimetypes))
	$allowed_mimetypes = PDd_retmime($_FILES['userfile']['name'], $usertype);

	$upload_dir = XOOPS_ROOT_PATH . "/" . $uploaddir . "/";

	$maxfilesize = $xoopsModuleConfig['maxfilesize']*1024;
	$maxfilewidth = $xoopsModuleConfig['maximgwidth'];
	$maxfileheight = $xoopsModuleConfig['maximgheight'];

	$uploader = new XoopsMediaUploader($upload_dir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);

	if ($uploader -> fetchMedia($_POST['xoops_upload_file'][$where]))
	{
		if (!$uploader -> upload())
		{
			$errors = $uploader -> getErrors();
			redirect_header($redirecturl, 2, $errors);
		}
		else
		{
			if ($redirect)
			redirect_header($redirecturl, 1 , _AM_PDD_UPLOADFILE);
			else if (is_file($uploader->savedDestination))
			{
				$down['url'] = XOOPS_URL . "/" . $uploaddir . "/" . strtolower($uploader->savedFileName);
				$down['size'] = filesize(XOOPS_ROOT_PATH . "/" . $uploaddir . "/" . strtolower($uploader->savedFileName));
			}
			return $down;
		}
	}
	else
	{
		$errors = $uploader -> getErrors();
		redirect_header($redirecturl, 1, $errors);
	}
}

function PDd_getforum($forumid)
{
	global $xoopsDB, $xoopsConfig;

	echo "<select name='forumid'>";
	echo "<option value='0'>----------------------</option>";
	$result = $xoopsDB -> query("SELECT forum_name, forum_id FROM " . $xoopsDB -> prefix("bb_forums") . " ORDER BY forum_id");
	while (list($forum_name, $forum_id) = $xoopsDB -> fetchRow($result))
	{
		if ($forum_id == $forumid)
		{
			$opt_selected = "selected='selected'";
		}
		else
		{
			$opt_selected = "";
		}
		echo "<option value='" . $forum_id . "' $opt_selected>" . $forum_name . "</option>";
	}
	echo "</select></div>";
	return $forumid;
}

function PDd_downlistheader($heading)
{
	echo "
		<fieldset><legend style='font-weight: bold; color: #900;'>" . $heading . "</legend><br />\n
		<table width='100%' cellspacing='1' cellpadding='2' border='0' class = 'outer'>\n
		<tr>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_ID . "</b></th>\n
		<th><b>" . _AM_PDD_MINDEX_TITLE . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_POSTER . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_SUBMITTED . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_PUBLISHED . "</b></th>\n
		<th align='center'><b>" . _AM_PDD_MINDEX_ACTION . "</b></th>\n
		</tr>\n
		";
}

function PDd_downlistbody($published)
{
	global $myts, $imagearray;

	$lid = $published['lid'];
	$cid = $published['cid'];
	$title = "<a href='../singlefile.php?cid=" . $published['cid'] . "&lid=" . $published['lid'] . "'>" . $myts -> htmlSpecialChars(trim($published['title'])) . "</a>";;
	$submitter = xoops_getLinkedUnameFromId(intval($published['submitter']));
	$publish = formatTimestamp($published['published'], 's');
	$offline = ($published['offline'] == 0) ? $imagearray['online'] : $imagearray['offline'];
	$modify = "<a href='index.php?op=Download&lid=" . $lid . "'>" . $imagearray['editimg'] . "</a>";
	$delete = "<a href='index.php?op=delDownload&lid=" . $lid . "'>" . $imagearray['deleteimg'] . "</a>";

	echo "
		<tr>\n
		<td class='head' align='center'>" . $lid . "</td>\n
		<td class='even'>" . $title . "</td>\n
		<td class='even' align='center'>" . $submitter . "</td>\n
		<td class='even' align='center'>" . $publish . "</td>\n
		<td class='even' align='center'>" . $offline . "</td>\n
		<td class='even' align='center' width = '10%' nowrap>$modify $delete</td>\n
		</tr>\n
		";
	unset($published);
}

function PDd_downlistfooter()
{
	echo "
		<tr>\n
		<td class='head' align='center' colspan= '7'>" . _AM_PDD_MINDEX_NODOWNLOADSFOUND . "</td>\n
		</tr>\n
		";
}

function PDd_downlistpagenav($pubrowamount, $start, $art = "art")
{
	global $xoopsModuleConfig;

	echo "</table>\n";
	$pagenav = new XoopsPageNav($pubrowamount, $xoopsModuleConfig['admin_perpage'], $start, 'st' . $art);
	echo '<div align="right" style="padding: 8px;">' . $pagenav -> renderImageNav() . '</div>';
	echo "</fieldset><br />";
}

function &PDd_getPathStatus($path)
{
	if(empty($path)) return false;
	if(@is_writable($path)){
		$path_status = _MD_PDD_AVAILABLE;	}
		elseif(!@is_dir($path)){
			if( ini_get('safe_mode') ){$path_status = _MD_PDD_NOTAVAILABLE ."&nbsp;". _MD_PDD_CREATEMANUAL; }
			else{
				$path_status = _MD_PDD_NOTAVAILABLE." <a href=index.php?op=createdir&amp;path=$path>"._MD_PDD_CREATETHEDIR.'</a>';
			}}
			else{
				if( ini_get('safe_mode') ){$path_status = _MD_PDD_NOTWRITABLE ."&nbsp;". _MD_PDD_CHMODMANUAL; }
				else{$path_status = _MD_PDD_NOTWRITABLE." <a href=index.php?op=setperm&amp;path=$path>"._MD_PDD_SETMPERM.'</a>';
				}}
				return $path_status;
}

function PDd_mkdir($target, $mode=0777)
{
	return is_dir($target) or ( PDd_mkdir(dirname($target), $mode) and mkdir($target, $mode) );

}

function PDd_chmod($target, $mode = 0777)
{
	return @chmod($target, $mode);
}
?>

