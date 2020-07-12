<?php 
/**
 * $Id: PDdownloads.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

/**
 * Function: b_mydownloads_top_show
 * Input   : $options[0] = date for the most recent downloads
 *                     hits for the most popular downloads
 *            $block['content'] = The optional above content
 *            $options[1]   = How many downloads are displayes
 * Output  : Returns the most recent or most popular downloads
 */

if( ! defined( 'PDDOWNLOADS_BLOCK_INCLUDED' ) ) {

	define( 'PDDOWNLOADS_BLOCK_INCLUDED' , 1 ) ;

	function b_PDdownloads_top_show($options)
	{
		global $xoopsDB, $xoopsModule, $xoopsUser;

		$mydirname = empty( $options[3] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[3] ;
		if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
		$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
		$block = array();
		$myts = &MyTextSanitizer::getInstance();
		$modhandler = &xoops_gethandler('module');
		$xoopsModule = &$modhandler->getByDirname($mydirname);
		$module_id = $xoopsModule->getVar('mid');
		$config_handler = &xoops_gethandler('config');
		$xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $module_id);
		$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$time_cur = time();
		$result = $xoopsDB->query("SELECT a.lid, a.cid, a.title, a.$options[0], b.* FROM " . $xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads") . " a, ".$xoopsDB->prefix('group_permission')." b WHERE a.lid = b.gperm_itemid AND a.offline = 0 AND (a.published > 0 AND a.published <= $time_cur) AND (a.expired = 0 OR a.expired > $time_cur) AND b.gperm_modid = $module_id AND b.gperm_name = \"PDDownFilePerm{$mydirnumber}\" AND b.gperm_groupid = $groups[0] ORDER BY " . $options[0] . " DESC", $options[1], 0);
		while($myrow = $xoopsDB->fetchArray($result))
		{
			$download = array();
			$title = $myts->htmlSpecialChars($myrow["title"]);
			if (!XOOPS_USE_MULTIBYTES)
			{
				if (strlen($myrow['title']) >= $options[2])
				{
					$title = $myts->htmlSpecialChars(substr($myrow['title'], 0, ($options[2] -1))) . "...";
				}
			}
			$download['id'] = $myrow['lid'];
			$download['cid'] = $myrow['cid'];
			$download['title'] = $title;
			if ($options[0] == "published")
			{
				$download['date'] = formatTimestamp($myrow['published'], $xoopsModuleConfig['dateformat']);
			}elseif ($options[0] == "hits")
			{
				$download['hits'] = $myrow['hits'];
			}
			$download['dirname'] = $xoopsModule->dirname();
			$block['downloads'][] = $download;
		}
		return $block;
	}

	function b_PDdownloads_top_edit($options)
	{
		$mydirname = empty( $options[3] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[3] ;
		$form = "" . _MB_PDD_DISP . "&nbsp;";
		$form .= "<input type='hidden' name='options[]' value='";
		if ($options[0] == "published")
		{
			$form .= "published'";
		}
		else
		{
			$form .= "hits'";
		}
		$form .= " />";
		$form .= "<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_PDD_FILES . "";
		$form .= "&nbsp;<br />" . _MB_PDD_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_PDD_LENGTH . "";
		$form .= "<input type='hidden' name='options[]' value='$mydirname' />\n" ;
		return $form;
	}
}

?>
