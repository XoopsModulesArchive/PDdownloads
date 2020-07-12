<?php
/**
 * $Id: header.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include_once '../../mainfile.php';

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

include XOOPS_ROOT_PATH."/modules/$mydirname/include/functions.php";

$myts = & MyTextSanitizer :: getInstance(); // MyTextSanitizer object
?>