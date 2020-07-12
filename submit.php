<?php
/**
 * $Id: submit.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
include XOOPS_ROOT_PATH . '/header.php';
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once "class/PDd_lists.php";

global $xoopsDB, $myts, $mytree, $xoopsModuleConfig, $xoopsConfig, $_FILES, $xoopsUser;

if ($xoopsUser && !array_intersect($xoopsModuleConfig['submitarts'], $xoopsUser->getGroups()) || !$xoopsUser && isset($xoopsModuleConfig['anonpost']) && !$xoopsModuleConfig['anonpost'] == 1)
{
	redirect_header("index.php", 1, _MD_PDD_NOTALLOWESTOSUBMIT);
	exit();
}
else
$suballow=1;

if ($suballow==1 && isset($_POST['submit']) && !empty($_POST['submit']))
{
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
	redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());

	$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$module_id = $xoopsModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');
	$notify = !empty($_POST['notify']) ? 1 : 0;

	$lid = (!empty($_POST['lid'])) ? intval($_POST['lid']) : 0 ;
	if (!isset($_POST['cid']) || $_POST['cid'] == 0)
	redirect_header("index.php", 3, _MD_PDD_SELCAT);
	else
	$cid = intval($_POST['cid']);
	if (!$gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $cid, $groups, $module_id))
	redirect_header("index.php", 3, _NOPERM);

	if (empty($_FILES['userfile']['name']) && $_POST["url"])
	{
		$url = ($_POST["url"] != "http://") ? $myts->addslashes($_POST["url"]) : '';
		$size = (!empty($_POST['size'])) ? intval($_POST['size']*1024) : 0 ;
		$title = $myts->addslashes(trim($_POST["title"]));
	}
	else
	{
		$down = PDd_uploading($_FILES, $xoopsModuleConfig['uploaddir'], "", "index.php", 0, 0, 0);
		$url = $down['url'];
		$size = $down['size'];
		$title = $_FILES['userfile']['name'];
		$title = rtrim(PDd_strrrchr($title, "."), ".");
		$title = (isset($_POST["title_checkbox"]) && $_POST["title_checkbox"] == 1) ? $title : $myts->addslashes(trim($_POST["title"]));
	}

	$homepage = '';
	$homepagetitle = '';
	if (!empty($_POST["homepage"]) || $_POST["homepage"] != "http://")
	{
		$homepage = $myts->addslashes(formatURL(trim($_POST["homepage"])));
		$homepagetitle = $myts->addslashes(trim($_POST["homepagetitle"]));
	}
	$version = $myts->addslashes($_POST["version"]);
	$platform = $myts->addslashes($_POST["platform"]);
	$descriptionb = $myts -> addslashes(trim($_POST["descriptionb"]));
	$submitter = !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
	$features = $myts->addslashes(trim($_POST["features"]));
	$forumid = (isset($_POST["forumid"]) && $_POST["forumid"] > 0) ? intval($_POST["forumid"]) : 0;
	$dhistory = (isset($_POST["dhistory"])) ? $myts->addslashes($_POST["dhistory"]) : '';
	$dhistoryhistory = (isset($_POST["dhistoryaddedd"])) ? $myts->addslashes($_POST["dhistoryaddedd"]) : '';

	if ($lid > 0 && !empty($dhistoryhistory))
	{
		$dhistory = $dhistory . "\n\n";
		$time = time();
		$dhistory .= "<b>" . formatTimestamp($time, $xoopsModuleConfig['dateformat']) . "</b>\n\n";
		$dhistory .= $dhistoryhistory;
	}
	$offline = (isset($_POST['offline']) && $_POST['offline'] == 1) ? 1 : 0;
	$date = time();
	$publishdate = 0;

	if (empty($_FILES['userscreen']['name']))
	$screenshot = ($_POST["screenshot"] != "blank.png") ? $myts -> addslashes($_POST["screenshot"]) : '';
	else if (empty($screenshot))
	{
		if (file_exists(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['screenshots'] . "/" . $_FILES['userscreen']['name']))
		redirect_header('index.php', 2, _AM_PDD_IMAGEEXIST);
		$allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png');
		PDd_uploading($_FILES, $xoopsModuleConfig['screenshots'], $allowed_mimetypes, "index.php", 1, 0, 1, 1);
		$screenshot = strtolower($_FILES['userscreen']['name']);
	}

	$ipaddress = $_SERVER['REMOTE_ADDR'];
	if ($lid == 0)
	{
		if ($xoopsModuleConfig['autoapprove'])
		{
			$publishdate = time();
			$status = 1;

			if ($xoopsModuleConfig['autoapproveforall'])
			{
				$groups = array();
				$result = $xoopsDB->query('SELECT COUNT(*) FROM '.$xoopsDB->prefix('groups'));
				for ($a=0; $a < $result; $a++)
				{
					$groups[$a] = $a;
				}
			}
		}
		else
		{
		$status = 0;
		$groups = array(1, 2);
		}

		$query = "INSERT INTO " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
			(lid, cid, title, url, homepage, version, size, platform, screenshot, submitter, status,
			date, hits, rating, votes, comments, features, homepagetitle, forumid, dhistory, published, expired, offline, description, ipaddress, notifypub)";
		$query .= " VALUES 	('', $cid, '$title', '$url', '$homepage', '$version', $size, '$platform', '$screenshot',
			'$submitter', '$status', '$date', 0, 0, 0, 0, '$features', '$homepagetitle', '$forumid', '$dhistory', '$publishdate',
			0, '$offline', '$descriptionb', '$ipaddress', '$notify')";
		$result = $xoopsDB->queryF($query);
		$error = _MD_PDD_INFONOSAVEDB;
		$error .= $query;
		if (!$result)
		trigger_error($error, E_USER_ERROR);

		$newid = $xoopsDB->getInsertId();

		PDd_save_Permissions($groups, $newid, "PDDownFilePerm{$mydirnumber}");
		/*
		*  Notify of new download (anywhere) and new download in category
		*/
		$notification_handler = &xoops_gethandler('notification');
		$tags = array();
		$tags['FILE_NAME'] = $title;
		$tags['FILE_URL'] = XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . "&lid=" . $newid;
		$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $cid;
		$result = $xoopsDB->query($sql);
		$row = $xoopsDB->fetchArray($result);
		$tags['CATEGORY_NAME'] = $row['title'];
		$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $cid;
		if ($xoopsModuleConfig['autoapprove'] == 1)
		{
			$notification_handler->triggerEvent('global', 0, 'new_file', $tags);
			$notification_handler->triggerEvent('category', $cid, 'new_file', $tags);
			redirect_header('index.php', 2, _MD_PDD_ISAPPROVED);
		}
		else
		{
			$tags['WAITINGFILES_URL'] = XOOPS_URL . "/modules/$mydirname/admin/newdownloads.php";
			$notification_handler->triggerEvent('global', 0, 'file_submit', $tags);
			$notification_handler->triggerEvent('category', $cid, 'file_submit', $tags);
			if ($notify)
			{
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler->subscribe('file', $newid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			redirect_header('index.php', 2, _MD_PDD_THANKSFORINFO);
		}
		exit();
	}
	else
	{
		$updated = (isset($_POST['up_dated']) && $_POST['up_dated'] == 0) ? 0 : time();

		if ($xoopsModuleConfig['autoapprove'] == 1)
		{
			$updated = time();
			$xoopsDB->query("UPDATE " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " SET cid = $cid, title = '$title',
			url = '$url', features = '$features', homepage = '$homepage', version = '$version', size = $size, platform = '$platform',
			homepagetitle = '$homepagetitle', dhistory = '$dhistory',
			updated = '$updated', offline = '$offline', description = '$descriptionb', ipaddress = '$ipaddress', notifypub = '$notify' WHERE lid = $lid");
			$notification_handler = &xoops_gethandler('notification');
			$tags = array();
			$tags['FILE_NAME'] = $title;
			$tags['FILE_URL'] = XOOPS_URL . "/modules/$mydirname/singlefile.php?cid=" . $cid . '&lid=' . $lid;
			$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat") . " WHERE cid=" . $cid;
			$result = $xoopsDB->query($sql);
			$row = $xoopsDB->fetchArray($result);
			$tags['CATEGORY_NAME'] = $row['title'];
			$tags['CATEGORY_URL'] = XOOPS_URL . "/modules/$mydirname/viewcat.php?cid=" . $cid;
			$notification_handler->triggerEvent('global', 0, 'new_file', $tags);
			$notification_handler->triggerEvent('category', $cid, 'new_file', $tags);
			redirect_header("index.php", 2, _MD_PDD_ISAPPROVED . "");
		}
		else
		{
			$modifysubmitter = $xoopsUser->uid();
			$requestid = $modifysubmitter;
			$requestdate = time();
			$sql = "INSERT INTO " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_mod") . "
				(requestid, lid, cid, title, url, homepage, version, size, platform, features, homepagetitle, forumid, dhistory, description, modifysubmitter, requestdate)";
			$sql .= " VALUES 	('', $lid, $cid, '$title', '$url', '$homepage', '$version', $size, '$platform',
				'$features', '$homepagetitle', '$forumid', '$dhistory', '$descriptionb',
				'$modifysubmitter', '$requestdate')";
			$result = $xoopsDB->query($sql);
			$error = "" . _MD_PDD_ERROR . ": <br /><br />" . $sql;
			if (!$result)
			trigger_error($error, E_USER_ERROR);
			$tags = array();
			$tags['MODIFYREPORTS_URL'] = XOOPS_URL . "/modules/$mydirname/admin/index.php?op=listModReq";
			$notification_handler = &xoops_gethandler('notification');
			$notification_handler->triggerEvent('global', 0, 'file_modify', $tags);

			$tags['WAITINGFILES_URL'] = XOOPS_URL . "/modules/$mydirname/admin/index.php?op=listNewDownloads";
			$notification_handler->triggerEvent('global', 0, 'file_submit', $tags);
			$notification_handler->triggerEvent('category', $cid, 'file_submit', $tags);
			if ($notify)
			{
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler->subscribe('file', $newid, 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			redirect_header('index.php', 2, _MD_PDD_THANKSFORINFO);
			exit();
		}
	}
}
else
{
	if ($xoopsModuleConfig['showdisclaimer'] && !isset($_GET['agree']))
	{
		echo "
		<p><div align = 'center'>" . PDd_imageheader() . "</div></p>\n
		<h4>" . _MD_PDD_DISCLAIMERAGREEMENT . "</h4>\n
		<p><div>" . $myts->displayTarea($xoopsModuleConfig['disclaimer'], 0, 1, 1, 1, 1) . "</div></p>\n
		<form action='submit.php' method='post'>\n
		<div align='center'><b>" . _MD_PDD_DOYOUAGREE . "</b><br /><br />\n
		<input type = 'button' onclick = 'location=\"submit.php?agree=1\"' class='formButton' value='" . _MD_PDD_AGREE . "' alt='" . _MD_PDD_AGREE . "' />\n
		&nbsp;\n
		<input type='button' onclick = 'location=\"index.php\"' class='formButton' value='" . _CANCEL . "' alt='" . _CANCEL . "' />\n
		</div></form>\n";
		include XOOPS_ROOT_PATH . '/footer.php';
		exit();
	}

	$lid = 0;
	$cid = 0;
	$title = '';
	$url = 'http://';
	$homepage = 'http://';
	$homepagetitle = '';
	$version = '';
	$size = 0;
	$platform = '';
	$descriptionb = '';
	$features = '';
	$forumid = 0;
	$dhistory = '';
	$screenshot = '';
	$status = 0;
	$is_updated = 0;
	$offline = 0;
	$published = 0;
	$expired = 0;
	$updated = 0;
	$versiontypes = '';

	if (isset($_POST['lid']))
	$lid = $_POST['lid'];
	elseif (isset($_GET['lid']))
	$lid = $_GET['lid'];
	else
	$lid = 0;

	echo "
		<p><div align = 'center'>" . PDd_imageheader() . "</div></p>\n
		<div>" . _MD_PDD_SUB_SNEWMNAMEDESC . "</div>\n";
	if ($lid)
	{
		$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$module_id = $xoopsModule->getVar('mid');
		$gperm_handler = &xoops_gethandler('groupperm');
		$time_cur = time();

		$result = $xoopsDB->query("SELECT a.*, b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE (a.lid = $lid AND b.gperm_itemid = $lid) AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0]");
		$down_array = $xoopsDB->fetchArray($result);
		$lid = $myts->htmlSpecialChars($down_array['lid']);
		$cid = $myts->htmlSpecialChars($down_array['cid']);
		$title = $myts->htmlSpecialChars($down_array['title']);
		$url = $myts->htmlSpecialChars($down_array['url']);
		$homepage = $myts->htmlSpecialChars($down_array['homepage']);
		$homepagetitle = $myts->htmlSpecialChars($down_array['homepagetitle']);
		$version = $myts->htmlSpecialChars($down_array['version']);
		$size = intval($down_array['size']/1024);
		$platform = $myts->htmlSpecialChars($down_array['platform']);
		$descriptionb = $myts -> htmlSpecialChars($down_array['description']);
		$screenshot = $myts->htmlSpecialChars($down_array['screenshot']);
		$features = $myts->htmlSpecialChars($down_array['features']);
		$dhistory = $myts->htmlSpecialChars($down_array['dhistory']);
		$published = $myts->htmlSpecialChars($down_array['published']);
		$expired = $myts->htmlSpecialChars($down_array['expired']);
		$updated = $myts->htmlSpecialChars($down_array['updated']);
		$offline = $myts->htmlSpecialChars($down_array['offline']);

		if (!$down_array)
		{
			$result2 = $xoopsDB->query("SELECT lid FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " WHERE lid = $lid");
			if ($xoopsDB->getRowsNum($result2) > 0)
			redirect_header(XOOPS_URL,3,_NOPERM);
			else
			redirect_header("index.php", 1, _MD_PDD_NODOWNLOAD);
			exit();
		}
	}
	$sform = new XoopsThemeForm(_MD_PDD_SUBMITCATHEAD, "storyform", xoops_getenv('PHP_SELF'), "post", true);
	$sform->setExtra('enctype="multipart/form-data"');

	$sform->addElement(new XoopsFormText(_MD_PDD_FILETITLE, 'title', 50, 255, $title), true);
	$sform->addElement(new XoopsFormText(_MD_PDD_DLURL, 'url', 50, 255, $url), true);
	if ($xoopsModuleConfig['useruploads'])
	$sform->addElement(new XoopsFormFile(""._MD_PDD_UPLOAD_FILEC." <span style='font-weight: normal;'>"._MD_PDD_UPLOAD_FILESIZE."".PDd_PrettySize(intval($xoopsModuleConfig['maxfilesize'])*1024)."</span>", 'userfile', 0), false);
	ob_start();
	$mytree->makeMySelBox('title', 'title', $cid, 1);
	$sform->addElement(new XoopsFormLabel(_MD_PDD_CATEGORYC, ob_get_contents()), true);
	ob_end_clean();

	$sform->addElement(new XoopsFormText(_MD_PDD_HOMEPAGETITLEC, 'homepagetitle', 50, 255, $homepagetitle), false);
	$sform->addElement(new XoopsFormText(_MD_PDD_HOMEPAGEC, 'homepage', 50, 255, $homepage), false);
	$sform->addElement(new XoopsFormText(_MD_PDD_VERSIONC, 'version', 10, 20, $version), false);
	$sform->addElement(new XoopsFormText(_MD_PDD_FILESIZEC, 'size', 10, 20, $size), false);

	$platform_array = $xoopsModuleConfig['platform'];
	$platform_select = new XoopsFormSelect('', 'platform', $platform, '', '', 0);
	$platform_select->addOptionArray($platform_array);
	$platform_tray = new XoopsFormElementTray(_MD_PDD_PLATFORMC, '&nbsp;');
	$platform_tray->addElement($platform_select);
	$sform->addElement($platform_tray);
	$graph_array = & PDsLists :: getListTypeAsArray(XOOPS_ROOT_PATH . "/" . $xoopsModuleConfig['screenshots'], $type = "images");
	$indeximage_select = new XoopsFormSelect('', 'screenshot', $screenshot);
	$indeximage_select -> addOptionArray($graph_array);
	$indeximage_select -> setExtra("onchange='showImgSelected(\"image\", \"screenshot\", \"" . $xoopsModuleConfig['screenshots'] . "\", \"\", \"" . XOOPS_URL . "\")'");
	$indeximage_tray = new XoopsFormElementTray(_AM_PDD_SHOTIMAGE, '&nbsp;');
	$indeximage_tray -> addElement($indeximage_select);
	if (!empty($imgurl))
	$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/" . $xoopsModuleConfig['screenshots'] . "/" . $screenshot . "' name='image' id='image' alt='' />"));
	else
	$indeximage_tray -> addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />"));
	$sform -> addElement($indeximage_tray);
	if ($xoopsModuleConfig['useruploads'])
	$sform->addElement(new XoopsFormFile(_AM_PDD_UPLOADSHOTIMAGE, 'userscreen', 0), false);
	$sform -> addElement(new XoopsFormDhtmlTextArea(_MD_PDD_DESCRIPTION, 'descriptionb', $descriptionb, 15, 60), true);
	$sform->addElement(new XoopsFormTextArea(_MD_PDD_KEYFEATURESC, 'features', $features, 7, 60), false);
	$sform->addElement(new XoopsFormTextArea(_MD_PDD_HISTORYC, 'dhistory', $dhistory, 7, 60), false);
	if ($lid && !empty($dhistory))
	$sform->addElement(new XoopsFormTextArea(_MD_PDD_HISTORYD, 'dhistoryaddedd', "", 7, 60), false);

	$option_tray = new XoopsFormElementTray(_MD_PDD_OPTIONS, '<br />');
	$notify_checkbox = new XoopsFormCheckBox('', 'notify');
	$notify_checkbox->addOption(1, _MD_PDD_NOTIFYAPPROVE);
	$option_tray->addElement($notify_checkbox);
	$sform->addElement($option_tray);
	$button_tray = new XoopsFormElementTray('', '');

	$button_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
	$button_tray->addElement(new XoopsFormHidden('lid', $lid));
	$sform->addElement($button_tray);
	$sform->display();
	include XOOPS_ROOT_PATH . '/footer.php';
}

?>
