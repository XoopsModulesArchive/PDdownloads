<?php
/* $Id: notification.inc.php
* Module: PD-Downloads
* Version: v1.2
* Release Date: 21. Dec 2005
* Author: Power-Dreams Team
* Licence: GNU
*/

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) die ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

eval( '

function PDdownloads'.$mydirnumber.'_notify_iteminfo($category, $item_id)
{
	global $xoopsModule, $xoopsModuleConfig, $xoopsConfig , $xoopsDB ;

	if (empty($xoopsModule) || $xoopsModule->getVar("dirname") != "'.$mydirname.'") {
		$module_handler =& xoops_gethandler("module");
		$module =& $module_handler->getByDirname("'.$mydirname.'");
		$config_handler =& xoops_gethandler("config");
		$config =& $config_handler->getConfigsByCat(0,$module->getVar("mid"));
	} else {
		$module =& $xoopsModule;
		$config =& $xoopsModuleConfig;
	}
	$mod_url = XOOPS_URL . "/modules/" . $module->getVar("dirname") ;

	if ($category=="global") {
		$item["name"] = "";
		$item["url"] = "";
		return $item;
	}

	if ($category=="category") {
		// Assume we have a valid category id
		$sql = "SELECT title FROM " . $xoopsDB->prefix("PDdownloads'.$mydirnumber.'_cat") . " WHERE cid = $item_id";
		$result = $xoopsDB->query($sql); // TODO: error check
		$result_array = $xoopsDB->fetchArray($result);
		$item["name"] = $result_array["title"];
		$item["url"] = "$mod_url/viewcat.php?cid=" . $item_id;
		return $item;
	}

	if ($category=="file") {
		// Assume we have a valid file id
		$sql = "SELECT cid,title FROM ".$xoopsDB->prefix("PDdownloads'.$mydirnumber.'_downloads") . " WHERE lid = $item_id";
		$result = $xoopsDB->query($sql); // TODO: error check
		$result_array = $xoopsDB->fetchArray($result);
		$item["name"] = $result_array["title"];
		$item["url"] = "$mod_url/singlefile.php?cid=" . $result_array["cid"] . "&amp;lid=" . $item_id;
		return $item;
	}
}
' ) ;
?>
