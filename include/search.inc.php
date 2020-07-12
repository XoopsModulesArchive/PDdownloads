<?php 
/* $Id: search.inc.php,v 1.8 2005/07/25 Power-Dreams Team
* Module: PD-Downloads
* Version: v1.2
* Release Date: 04. März 2005
* Author: Power-Dreams Team
* Licence: GNU
*/

if (empty($mydirname)){
	include 'mydirname.php';
}

eval( '

function PDdownloads'.$mydirnumber.'_search( $queryarray, $andor, $limit, $offset, $userid )
{
	return PDdownloads_search_base( "'.$mydirname.'" , "'.$mydirnumber.'" , $queryarray, $andor, $limit, $offset, $userid ) ;
}

' ) ;

if( ! function_exists( 'PDdownloads_search_base' ) ) {

	function PDdownloads_search_base($mydirname, $mydirnumber, $queryarray, $andor, $limit, $offset, $userid)
	{
		global $xoopsDB, $xoopsUser;

		$sql = "SELECT lid, cid, title, submitter, published, description FROM " . $xoopsDB -> prefix("PDdownloads{$mydirnumber}_downloads") . "
	WHERE status >0 AND published > 0";
		if ($userid != 0)
		{
			$sql .= " AND submitter=" . $userid . " ";
		}
		// because count() returns 1 even if a supplied variable
		// is not an array, we must check if $querryarray is really an array
		if (is_array($queryarray) && $count = count($queryarray))
		{
			$sql .= " AND ((title LIKE '%$queryarray[0]%' OR description LIKE '%$queryarray[0]%')";
			for($i = 1;$i < $count;$i++)
			{
				$sql .= " $andor ";
				$sql .= "(title LIKE '%$queryarray[$i]%' OR description LIKE '%$queryarray[$i]%')";
			}
			$sql .= ") ";
		}
		$sql .= "ORDER BY date DESC";
		$result = $xoopsDB -> query($sql, $limit, $offset);
		$ret = array();
		$i = 0;

		$groups = (is_object($xoopsUser)) ? $xoopsUser -> getGroups() : XOOPS_GROUP_ANONYMOUS;
		$modhandler = & xoops_gethandler('module');
		$xoopsPDDModule = & $modhandler -> getByDirname($mydirname);
		$gperm_handler = & xoops_gethandler('groupperm');

		while ($myrow = $xoopsDB -> fetchArray($result))
		{
			if (!$gperm_handler -> checkRight("PDDownFilePerm{$mydirnumber}", $myrow['lid'] , $groups, $xoopsPDDModule -> getVar('mid')))
			continue;
			$ret[$i]['image'] = "images/size2.gif";
			$ret[$i]['link'] = "singlefile.php?cid=" . $myrow['cid'] . "&lid=" . $myrow['lid'] . "";
			$ret[$i]['title'] = $myrow['title'];
			$ret[$i]['time'] = $myrow['published'];
			$ret[$i]['uid'] = $myrow['submitter'];
			$i++;
		}
		return $ret;
	}
}

?>
