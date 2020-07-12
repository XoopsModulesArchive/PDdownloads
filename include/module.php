<?php
/**
 * $Id: module.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */
 
if(defined("XOOPS_MODULE_PDDOWNLOADS_FUCTIONS")) exit();
define("XOOPS_MODULE_PDDOWNLOADS_FUCTIONS", 1);

if (empty($mydirname))
include 'mydirname.php';

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_cat")." LIKE 'total'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_cat") . " ADD total int(11) NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'submitter'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD submitter int(11) NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'status'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD status tinyint(2) NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'date'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD date int(10) NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'hits'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD hits int(11) unsigned NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'rating'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD rating double(6,4) NOT NULL default '0.0000'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'votes'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD votes int(11) unsigned NOT NULL default '0'");

if (!$GLOBALS['xoopsDB']->getRowsNum($GLOBALS['xoopsDB'] -> queryF("show fields from ".$GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod")." LIKE 'comments'")) > 0)
$GLOBALS['xoopsDB'] -> queryF("ALTER TABLE " . $GLOBALS['xoopsDB'] -> prefix("PDdownloads{$mydirnumber}_mod") . " ADD comments int(11) unsigned NOT NULL default '0'");
?>