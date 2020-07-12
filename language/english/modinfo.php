<?php
/**
 * $Id: main.php v 1.15 02 july 2004 Liquid Exp $
 * Module: PD-Downloads
 * Version: v1.0
 * Release Date: 04. März 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( '_MI_PDD_NAME' ) ) {

	// Module Info
	// The name of this module
	define("_MI_PDD_NAME","PD-Downloads");

	// A brief description of this module
	define("_MI_PDD_DESC","Creates a downloads section where users can download/submit/rate various files.");

	// Names of blocks for this module (Not all module has blocks)
	define("_MI_PDD_BNAME1","Recent PD-Downloads");
	define("_MI_PDD_BNAME2","Top PD-Downloads");

	// Sub menu titles
	define("_MI_PDD_SMNAME1","Submit");
	define("_MI_PDD_SMNAME2","Popular");
	define("_MI_PDD_SMNAME3","Top Rated");
	define("_MI_PDD_SMNAME4","My Downloads");

	// Names of admin menu items
	define("_MI_PDD_BINDEX","Main Index");
	define("_MI_PDD_INDEXPAGE","Index Page Management");
	define("_MI_PDD_MCATEGORY","Category Management");
	define("_MI_PDD_MDOWNLOADS","File Management");
	define("_MI_PDD_MUPLOADS","Image Upload");
	define("_MI_PDD_MMIMETYPES","Mimetypes Management");
	define("_MI_PDD_PERMISSIONS","Permission Settings");
	define("_MI_PDD_BLOCKADMIN","Block Settings");
	define("_MI_PDD_MVOTEDATA","Votes");

	// Title of config items
	define('_MI_PDD_POPULAR', 'Download Popular Count');
	define('_MI_PDD_POPULARDSC', 'The number of hits before a Download status will be considered as popular.');

	//Display Icons
	define("_MI_PDD_ICONDISPLAY","Downloads Popular and New:");
	define("_MI_PDD_DISPLAYICONDSC", "Select how to display the popular and new icons in download listing.");
	define("_MI_PDD_DISPLAYICON1", "Display As Icons");
	define("_MI_PDD_DISPLAYICON2", "Display As Text");
	define("_MI_PDD_DISPLAYICON3", "Do Not Display");

	define("_MI_PDD_DAYSNEW","Downloads Days New:");
	define("_MI_PDD_DAYSNEWDSC","The number of days a download status will be considered as new.");
	define("_MI_PDD_DAYSUPDATED","Downloads Days Updated:");
	define("_MI_PDD_DAYSUPDATEDDSC","The amount of days a download status will be considered as updated.");

	define("_MI_PDD_SHOWDLONINDEX","Show newest downloads on module-startpage??");
	define("_MI_PDD_SHOWDLONINDEXDSC","Shows the newest downloads on the module-startpage.");

	define('_MI_PDD_PERPAGE', 'Download Listing Count:');
	define('_MI_PDD_PERPAGEDSC', 'Number of Downloads to display in each category listing.');

	define('_MI_PDD_USESHOTS', 'Display Screenshot Images?');
	define('_MI_PDD_USESHOTSDSC', 'Select yes to display screenshot images for each download item');
	define('_MI_PDD_SHOTWIDTH', 'Image Display Width');
	define('_MI_PDD_SHOTWIDTHDSC', 'Display width for screenshot image');
	define('_MI_PDD_SHOTHEIGHT', 'Image Display Height');
	define('_MI_PDD_SHOTHEIGHTDSC', 'Display height for screenshot image');
	define('_MI_PDD_CHECKHOST', 'Disallow direct download linking? (leeching)');
	define('_MI_PDD_REFERERS', 'These sites can directly link to your files <br />Separate with <b>#</b>');
	define("_MI_PDD_ANONPOST","Anonymous User Submission:");
	define("_MI_PDD_ANONPOSTDSC","Allow Anonymous users to submit or upload to your website?");
	define('_MI_PDD_AUTOAPPROVE','Auto Approve Submitted Downloads');
	define('_MI_PDD_AUTOAPPROVEDSC','Select to approve submitted downloads without moderation.');
	define('_MI_PDD_AUTOAPPROVEFORALL','Auto Approve Downloads for ALL Users:');
	define('_MI_PDD_AUTOAPPROVEFORALLDSC','<b>YES</b> - Alle groups even anonym users will have automatically access to the download.<br><b>NO</b> - Only \'Webmaster\'and \'Registered Members\' will have automatically access to the download.');

	define('_MI_PDD_MAXFILESIZE','Upload Size (KB)');
	define('_MI_PDD_MAXFILESIZEDSC','Maximum file size permitted with file uploads.');
	define('_MI_PDD_IMGWIDTH','Upload Image width');
	define('_MI_PDD_IMGWIDTHDSC','Maximum image width permitted when uploading image files');
	define('_MI_PDD_IMGHEIGHT','Upload Image height');
	define('_MI_PDD_IMGHEIGHTDSC','Maximum image height permitted when uploading image files');

	define('_MI_PDD_UPLOADDIR','Upload Directory (No trailing slash)');
	define('_MI_PDD_ALLOWSUBMISS','User Submissions:');
	define('_MI_PDD_ALLOWSUBMISSDSC','Allow Users to Submit new files and screenshots');
	define('_MI_PDD_ALLOWUPLOADS','User Uploads:');
	define('_MI_PDD_ALLOWUPLOADSDSC','Allow Users to upload files directly to your website');
	define('_MI_PDD_SCREENSHOTS','Screenshots Upload Directory');
	define('_MI_PDD_CATEGORYIMG','Category Image Upload Directory');
	define('_MI_PDD_MAINIMGDIR','Main Image Directory');
	define('_MI_PDD_USETHUMBS', 'Use Thumb Nails:');
	define("_MI_PDD_USETHUMBSDSC", "Supported file types: JPG, GIF, PNG.<div style='padding-top: 8px;'>PD-Section will use thumb nails for images. Set to 'No' to use orginal image if the server does not support this option.</div>");
	define('_MI_PDD_DATEFORMAT', 'Timestamp:');
	define('_MI_PDD_DATEFORMATDSC', 'Default Timestamp for PD-Downloads:');
	define('_MI_PDD_SHOWDISCLAIMER', 'Show Disclaimer before User Submission?');
	define('_MI_PDD_SHOWDISCLAIMERDSC', 'Show Disclaimer before File-Upload from a User?');
	define('_MI_PDD_SHOWDOWNDISCL', 'Show Disclaimer before User Download?');
	define('_MI_PDD_SHOWDOWNDISCLDSC', 'Show Disclaimer befor downloading?');
	define('_MI_PDD_DISCLAIMER', 'Enter Submission Disclaimer Text:');
	define('_MI_PDD_DOWNDISCLAIMER', 'Enter Download Disclaimer Text:');
	define('_MI_PDD_PLATFORM', 'Enter Platforms:');
	define('_MI_PDD_SUBCATS', 'Sub-Categories:');
	define('_MI_PDD_VERSIONTYPES', 'Version Status:');
	define('_MI_PDD_LICENSE', 'Enter License:');

	define("_MI_PDD_SUBMITART", "Download Submission:");
	define("_MI_PDD_SUBMITARTDSC", "Select groups that can submit new downloads.");

	define("_MI_PDD_IMGUPDATE", "Update Thumbnails?");
	define("_MI_PDD_IMGUPDATEDSC", "If selected Thumbnail images will be updated at each page render, otherwise the first thumbnail image will be used regardless. <br /><br />");
	define("_MI_PDD_QUALITY", "Thumb Nail Quality:");
	define("_MI_PDD_QUALITYDSC", "Quality Lowest: 0 Highest: 100");
	define("_MI_PDD_KEEPASPECT", "Keep Image Aspect Ratio?");
	define("_MI_PDD_KEEPASPECTDSC", "");
	define("_MI_PDD_ADMINPAGE", "Admin Index Files Count:");
	define("_MI_PDD_AMDMINPAGEDSC", "Number of new files to display in module admin area.");
	define("_MI_PDD_ARTICLESSORT", "Default download Order:");
	define("_MI_PDD_ARTICLESSORTDSC", "Select the default order for the download listings.");
	define("_MI_PDD_TITLE", "Title");
	define("_MI_PDD_RATING", "Rating");
	define("_MI_PDD_WEIGHT", "Weight");
	define("_MI_PDD_POPULARITY", "Popularity");
	define("_MI_PDD_SUBMITTED2", "Submission Date");
	define('_MI_PDD_COPYRIGHT', 'Copyright Notice:');
	define('_MI_PDD_COPYRIGHTDSC', 'Select to display a copyright notice on download page.');
	// Description of each config items
	define('_MI_PDD_PLATFORMDSC', 'List of platforms to enter <br />Separate with <b>|</b> IMPORTANT: Do not change this once the site is Live, Add new to the end of the list!');
	define('_MI_PDD_SUBCATSDSC', 'Select Yes to display sub-categories. Selecting No will hide sub-categories from the listings');
	define('_MI_PDD_LICENSEDSC', 'List of platforms to enter <br />Separate with <b>|</b>');
	define('_MI_PDD_RSS', 'Enable RSS Feeds per categorie?');
	define('_MI_PDD_RSSDSC', 'When you select <b>YES</b>, the content of categories can be access via RSS-Feed.');

	// Text for notifications
	define('_MI_PDD_GLOBAL_NOTIFY', 'Global');
	define('_MI_PDD_GLOBAL_NOTIFYDSC', 'Global downloads notification options.');

	define('_MI_PDD_CATEGORY_NOTIFY', 'Category');
	define('_MI_PDD_CATEGORY_NOTIFYDSC', 'Notification options that apply to the current file category.');

	define('_MI_PDD_FILE_NOTIFY', 'File');
	define('_MI_PDD_FILE_NOTIFYDSC', 'Notification options that apply to the current file.');

	define('_MI_PDD_GLOBAL_NEWCATEGORY_NOTIFY', 'New Category');
	define('_MI_PDD_GLOBAL_NEWCATEGORY_NOTIFYCAP', 'Notify me when a new file category is created.');
	define('_MI_PDD_GLOBAL_NEWCATEGORY_NOTIFYDSC', 'Receive notification when a new file category is created.');
	define('_MI_PDD_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file category');

	define('_MI_PDD_GLOBAL_FILEMODIFY_NOTIFY', 'Modify File Requested');
	define('_MI_PDD_GLOBAL_FILEMODIFY_NOTIFYCAP', 'Notify me of any file modification request.');
	define('_MI_PDD_GLOBAL_FILEMODIFY_NOTIFYDSC', 'Receive notification when any file modification request is submitted.');
	define('_MI_PDD_GLOBAL_FILEMODIFY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Modification Requested');

	define('_MI_PDD_GLOBAL_FILEBROKEN_NOTIFY', 'Broken File Submitted');
	define('_MI_PDD_GLOBAL_FILEBROKEN_NOTIFYCAP', 'Notify me of any broken file report.');
	define('_MI_PDD_GLOBAL_FILEBROKEN_NOTIFYDSC', 'Receive notification when any broken file report is submitted.');
	define('_MI_PDD_GLOBAL_FILEBROKEN_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : Broken File Reported');

	define('_MI_PDD_GLOBAL_FILESUBMIT_NOTIFY', 'File Submitted');
	define('_MI_PDD_GLOBAL_FILESUBMIT_NOTIFYCAP', 'Notify me when any new file is submitted (awaiting approval).');
	define('_MI_PDD_GLOBAL_FILESUBMIT_NOTIFYDSC', 'Receive notification when any new file is submitted (awaiting approval).');
	define('_MI_PDD_GLOBAL_FILESUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted');

	define('_MI_PDD_GLOBAL_NEPDILE_NOTIFY', 'New File');
	define('_MI_PDD_GLOBAL_NEPDILE_NOTIFYCAP', 'Notify me when any new file is posted.');
	define('_MI_PDD_GLOBAL_NEPDILE_NOTIFYDSC', 'Receive notification when any new file is posted.');
	define('_MI_PDD_GLOBAL_NEPDILE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file');

	define('_MI_PDD_CATEGORY_FILESUBMIT_NOTIFY', 'File Submitted');
	define('_MI_PDD_CATEGORY_FILESUBMIT_NOTIFYCAP', 'Notify me when a new file is submitted (awaiting approval) to the current category.');
	define('_MI_PDD_CATEGORY_FILESUBMIT_NOTIFYDSC', 'Receive notification when a new file is submitted (awaiting approval) to the current category.');
	define('_MI_PDD_CATEGORY_FILESUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file submitted in category');

	define('_MI_PDD_CATEGORY_NEPDILE_NOTIFY', 'New File');
	define('_MI_PDD_CATEGORY_NEPDILE_NOTIFYCAP', 'Notify me when a new file is posted to the current category.');
	define('_MI_PDD_CATEGORY_NEPDILE_NOTIFYDSC', 'Receive notification when a new file is posted to the current category.');
	define('_MI_PDD_CATEGORY_NEPDILE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New file in category');

	define('_MI_PDD_FILE_APPROVE_NOTIFY', 'File Approved');
	define('_MI_PDD_FILE_APPROVE_NOTIFYCAP', 'Notify me when this file is approved.');
	define('_MI_PDD_FILE_APPROVE_NOTIFYDSC', 'Receive notification when this file is approved.');
	define('_MI_PDD_FILE_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : File Approved');

	define('_MI_PDD_AUTHOR_INFO', "Developer Information");
	define('_MI_PDD_AUTHOR_NAME', "Developer");
	define('_MI_PDD_AUTHOR_WEBSITE', "Developer website");
	define('_MI_PDD_AUTHOR_EMAIL', "Developer email");
	define('_MI_PDD_AUTHOR_CREDITS', "Credits");
	define('_MI_PDD_MODULE_DEVINFO', "Module Development Information");
	define('_MI_PDD_MODULE_INFO', "Module Information");
	define('_MI_PDD_MODULE_STATUS', "Development Status");
	define('_MI_PDD_MODULE_DISCLAIMER', "Disclaimer");
	define('_MI_PDD_RELEASE', "Release Date: ");

	define('_MI_PDD_WARNINGTEXT', "THE SOFTWARE IS PROVIDED BY Power-Dreams \"AS IS\" AND \"WITH ALL FAULTS.\"
Power-Dreams MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND CONCERNING
THE QUALITY, SAFETY OR SUITABILITY OF THE SOFTWARE, EITHER EXPRESS OR
IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT.
FURTHER, ABLEMEDIA MAKES NO REPRESENTATIONS OR WARRANTIES AS TO THE TRUTH,
ACCURACY OR COMPLETENESS OF ANY STATEMENTS, INFORMATION OR MATERIALS
CONCERNING THE SOFTWARE THAT IS CONTAINED IN Power-Dreams WEBSITE. IN NO
EVENT WILL ABLEMEDIA BE LIABLE FOR ANY INDIRECT, PUNITIVE, SPECIAL,
INCIDENTAL OR CONSEQUENTIAL DAMAGES HOWEVER THEY MAY ARISE AND EVEN IF
Power-Dreams HAS BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES..");

	define('_MI_PDD_AUTHOR_CREDITSTEXT',"The Power-Dreams Team would like to thank the following people for their help and support during the development phase of this module:<br /><br />
Frankblack, King76, baerchen, mcleines, gibaphp, Michael and all Beta-Testers.");
	define('_MI_PDD_AUTHOR_BUGFIXES', "Version History");

	define('_MI_PDD_DIVIDECATEGORY', "Amount of categories side by side:");
	define('_MI_PDD_DIVCATDSC', "It allows you to choose how often the categories will be divided side by side.");
	define('_MI_PDD_DIVSUBCAT', "Amount of sub-categories side by side:");
	define('_MI_PDD_DIVSUBCATDSC', "It allows you to choose how often the sub-categories will be divided side by side.");
}
?>
