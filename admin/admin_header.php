<?php
/**
 * $Id: admin_header.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include '../../../mainfile.php';
include '../../../include/cp_header.php';
include '../include/functions.php';

if (empty($mydirname)){
	include '../include/mydirname.php';
}

include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

if (is_object($xoopsUser)) {
	$xoopsModule = XoopsModule::getByDirname($mydirname);
	if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
		redirect_header(XOOPS_URL . "/", 3, _NOPERM);
		exit();
	}
} else {
	redirect_header(XOOPS_URL . "/", 1, _NOPERM);
	exit();
}
$myts = &MyTextSanitizer::getInstance();

$imagearray = array(
'editimg' => "<img src='../images/icon/edit.gif' alt='" . _AM_PDD_ICO_EDIT . "' align='middle'>",
'deleteimg' => "<img src='../images/icon/delete.gif' alt='" . _AM_PDD_ICO_DELETE . "' align='middle'>",
'online' => "<img src='../images/icon/on.gif' alt='" . _AM_PDD_ICO_ONLINE . "' align='middle'>",
'offline' => "<img src='../images/icon/off.gif' alt='" . _AM_PDD_ICO_OFFLINE . "' align='middle'>",
'approved' => "<img src='../images/icon/on.gif' alt=''" . _AM_PDD_ICO_APPROVED . "' align='middle'>",
'notapproved' => "<img src='../images/icon/off.gif' alt='" . _AM_PDD_ICO_NOTAPPROVED . "' align='middle'>",
'relatedfaq' => "<img src='../images/icon/link.gif' alt='" . _AM_PDD_ICO_LINK . "' align='absmiddle'>",
'relatedurl' => "<img src='../images/icon/urllink.gif' alt='" . _AM_PDD_ICO_URL . "' align='middle'>",
'addfaq' => "<img src='../images/icon/add.gif' alt='" . _AM_PDD_ICO_ADD . "' align='middle'>",
'approve' => "<img src='../images/icon/approve.gif' alt='" . _AM_PDD_ICO_APPROVE . "' align='middle'>",
'statsimg' => "<img src='../images/icon/stats.gif' alt='" . _AM_PDD_ICO_STATS . "' align='middle'>",
'ignore' => "<img src='../images/icon/ignore.gif' alt='" . _AM_PDD_ICO_IGNORE . "' align='middle'>",
'ack_yes' => "<img src='../images/icon/on.gif' alt='" . _AM_PDD_ICO_ACK . "' align='middle'>",
'ack_no' => "<img src='../images/icon/off.gif' alt='" . _AM_PDD_ICO_REPORT . "' align='middle'>",
'con_yes' => "<img src='../images/icon/on.gif' alt='" . _AM_PDD_ICO_CONFIRM . "' align='middle'>",
'con_no' => "<img src='../images/icon/off.gif' alt='" . _AM_PDD_ICO_CONBROKEN . "' align='middle'>"
);

?>