<?php

/**
 * $Id: sitemap.plugin.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

eval( '

function b_sitemap_'.$mydirname.'(){
	return b_sitemap_base_PDdownloads( "'.$mydirname.'" ) ;
}

' ) ;

if( ! function_exists( 'b_sitemap_base_PDdownloads' ) ) {

	function b_sitemap_base_PDdownloads($mydirname){
		global $xoopsModuleConfig, $xoopsDB, $xoopsUser;
		if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
		$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
		$myts = &MyTextSanitizer::getInstance();
		$modhandler = &xoops_gethandler('module');
		$xoopsModule = &$modhandler->getByDirname($mydirname);
		$module_id = $xoopsModule->getVar('mid');
		$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$table = $xoopsDB->prefix("PDdownloads{$mydirnumber}_cat");
		$gperm_handler = &xoops_gethandler('groupperm');
		$id_name = "cid";
		$pid_name = "pid";
		$title_name = "title";
		$url = "viewcat.php?cid=";
		$order = $title_name;
		$mytree = new XoopsTree($table, $id_name, $pid_name);
		$sitemap = array();
		$i = 0;

		$result = $xoopsDB->query("SELECT a.$id_name, a.$title_name, b.* FROM " . $table . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.$id_name = b.gperm_itemid AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownCatPerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] AND a.$pid_name = 0 ORDER BY a.$order");

		while (list($catid, $name) = $xoopsDB->fetchRow($result))
		{
			$sitemap['parent'][$i]['id'] = $catid;
			$sitemap['parent'][$i]['title'] = $myts->makeTboxData4Show( $name ) ;
			$sitemap['parent'][$i]['url'] = $url.$catid;

			if(@$xoopsModuleConfig["show_subcategoris"]){
				$j = 0;
				$child_ary = $mytree->getChildTreeArray($catid, $order);
				foreach ($child_ary as $child)
				{
					if ($gperm_handler->checkRight("PDDownCatPerm{$mydirnumber}", $child['cid'], $groups, $module_id))
					{
						$count = strlen($child['prefix']) + 1;
						$sitemap['parent'][$i]['child'][$j]['id'] = $child[$id_name];
						$sitemap['parent'][$i]['child'][$j]['title'] = $myts->makeTboxData4Show( $child[$title_name] ) ;
						$sitemap['parent'][$i]['child'][$j]['image'] = (($count > 3) ? 4 : $count);
						$sitemap['parent'][$i]['child'][$j]['url'] = $url.$child[$id_name];

						$j++;
					}
				}
			}
			$i++;
		}

		return $sitemap;
	}
}
?>