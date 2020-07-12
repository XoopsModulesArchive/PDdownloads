<?php
/*************************************************************************/
# Waiting Contents Extensible                                            #
# Plugin for module PDdownloads                                          #
#                                                                        #
# Original Author                                                        #
# flying.tux     -   flying.tux@gmail.com                                #
#                                                                        #
# Extended and modified for PD-Downloads 1.2                             #
# by Power-Dreams Team                                                   #
#                                                                        #
# Last modified on 21.12.2005                                            #
/*************************************************************************/

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

eval( '

function b_waiting_'.$mydirname.'(){
	return b_waiting_base_PDdownloads( "'.$mydirname.'", "'.$mydirnumber.'" ) ;
}

' ) ;

if( ! function_exists( 'b_waiting_base_PDdownloads' ) ) {

	function b_waiting_base_PDdownloads($mydirname, $mydirnumber)
	{
		$xoopsDB =& Database::getInstance();
		$ret = array() ;

		// PDdownloads waiting
		$block = array();
		$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("PDdownloads{$mydirnumber}_downloads")." WHERE status=0");
		if ( $result ) {
			$block['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/newdownloads.php";
			list($block['pendingnum']) = $xoopsDB->fetchRow($result);
			$block['lang_linkname'] = _PI_WAITING_WAITINGS ;
		}
		$ret[] = $block ;

		// PDdownloads broken
		$block = array();
		$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("PDdownloads{$mydirnumber}_broken"));
		if ( $result ) {
			$block['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/brokendown.php";
			list($block['pendingnum']) = $xoopsDB->fetchRow($result);
			$block['lang_linkname'] = _PI_WAITING_BROKENS ;
		}
		$ret[] = $block ;

		// PDdownloads modreq
		$block = array();
		$result = $xoopsDB->query("SELECT COUNT(*) FROM ".$xoopsDB->prefix("PDdownloads{$mydirnumber}_mod"));
		if ( $result ) {
			$block['adminlink'] = XOOPS_URL."/modules/$mydirname/admin/modifications.php";
			list($block['pendingnum']) = $xoopsDB->fetchRow($result);
			$block['lang_linkname'] = _PI_WAITING_MODREQS ;
		}
		$ret[] = $block ;

		return $ret;
	}
}

?>