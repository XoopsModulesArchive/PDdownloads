<?php
/**
 * $Id: newsstory.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

$title = (!empty($_POST['newsTitle'])) ? $_POST['newsTitle'] : "$title "._AM_PDD_MINDEX_DOWNSEC."";
include_once XOOPS_ROOT_PATH . "/modules/$newsmodule/class/class.newsstory.php";
if (empty($mydirname)){
	include '../include/mydirname.php';
}

$story = new NewsStory();
$story -> setUid($xoopsUser -> uid());
$story -> setPublished(time());
$story -> setExpired(0);
$story -> setType("admin");
$story -> setHostname(getenv("REMOTE_ADDR"));
$story -> setApproved(1);
$topicid = $_POST["newstopicid"];
$story -> setTopicId($topicid);
$story -> setTitle($title);

$_fileid = (isset($lid) && $lid > 0) ? $lid : $newid;
$_link = $_POST["description"]."<br /><div><a href=".XOOPS_URL."/modules/$mydirname/singlefile.php?cid=".$cid."&lid=".$_fileid.">".$title."</a></div>";

$description = $myts->addslashes(trim($_link));
$story -> setHometext($description);
$story -> setBodytext('');
$nohtml = (empty($nohtml)) ? 0 : 1;
$nosmiley = (empty($nosmiley)) ? 0 : 1;
$story -> setNohtml($nohtml);
$story -> setNosmiley($nosmiley);
$story -> store();
$notification_handler = & xoops_gethandler('notification');
$tags = array();
$tags['STORY_NAME'] = $story -> title();

$tags['STORY_URL'] = XOOPS_URL . "/modules/$newsmodule/article.php?storyid=" . $story -> storyid();
if (!empty($isnew))
{
	$notification_handler -> triggerEvent('story', $story -> storyid(), 'approve', $tags);
}
$notification_handler -> triggerEvent('global', 0, 'new_story', $tags);

unset($xoopsModule);
?>