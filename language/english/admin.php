<?php
/**
 * $Id: admin.php v 1.22 02 july 2004 Liquid Exp $
 * Module: PD-Downloads
 * Version: v1.0
 * Release Date: 04. März 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( '_AM_PDD_BMODIFY' ) ) {

	define("_MD_PDD_NODOWNLOAD", "This download does not exist!");

	// Buttons
	define("_AM_PDD_BMODIFY", "Modify");
	define("_AM_PDD_BDELETE", "Delete");
	define("_AM_PDD_BADD", "Add");
	define("_AM_PDD_BAPPROVE", "Approve");
	define("_AM_PDD_BIGNORE", "Ignore");
	define("_AM_PDD_BCANCEL", "Cancel");
	define("_AM_PDD_BSAVE", "Save");
	define("_AM_PDD_BRESET", "Reset");
	define("_AM_PDD_BMOVE", "Move Files");
	define("_AM_PDD_BUPLOAD", "Upload");
	define("_AM_PDD_BDELETEIMAGE", "Delete Selected Image");
	define("_AM_PDD_BRETURN", "Return to where you where!");
	define("_AM_PDD_DBERROR", "Database Access Error: Please report this error to the PDSection Website");
	//Banned Users
	define("_AM_PDD_NONBANNED", "Not Banned");
	define("_AM_PDD_BANNED", "Banned");
	define("_AM_PDD_EDITBANNED", "Edit Banned Users");
	// Other Options
	define("_AM_PDD_TEXTOPTIONS", "Text Options:");
	define("_AM_PDD_DISABLEHTML", " Disable HTML Tags");
	define("_AM_PDD_DISABLESMILEY", " Disable Smilie Icons");
	define("_AM_PDD_DISABLEXCODE", " Disable XOOPS Codes");
	define("_AM_PDD_DISABLEIMAGES", " Disable Images");
	define("_AM_PDD_DISABLEBREAK", " Use XOOPS linebreak conversion?");
	define("_AM_PDD_UPLOADFILE", "File Uploaded Successfully");
	define("_AM_PDD_NOMENUITEMS", "No menu items within the menu");

	// Admin Bread crumb
	define("_AM_PDD_PREFS", "Preferences");
	define("_AM_PDD_PERMISSIONS", "Permissions");
	define("_AM_PDD_BINDEX", "Main Index");
	define("_MI_PDD_BLOCKADMIN","Block Settings");
	define("_AM_PDD_BLOCKADMIN", "Blocks");
	define("_AM_PDD_GOMODULE", "Go to module");
	define("_AM_PDD_ABOUT", "About");
	define("_AM_PDD_UANDITOOL", "Upgrade and Import Tool");
	// Admin Summary
	define("_AM_PDD_SCATEGORY", "Category: ");
	define("_AM_PDD_SFILES", "Files: ");
	define("_AM_PDD_SNEPDILESVAL", "Submitted: ");
	define("_AM_PDD_SMODREQUEST", "Modified: ");
	// Admin Main Menu
	define("_AM_PDD_MCATEGORY", "Category Management");
	define("_AM_PDD_MDOWNLOADS", "Create new Download");
	define("_AM_PDD_INDEXPAGE", "Index Page Management");
	define("_AM_PDD_MMIMETYPES", "Mimetypes Management");
	define("_AM_PDD_MVOTEDATA", "Vote Data");
	define("_AM_PDD_MUPLOADS", "Upload Picture");
	define("_AM_PDD_STATISTIC", "Statistic");

	// Catgeory defines
	define("_AM_PDD_CCATEGORY_CREATENEW", "Create New Category");
	define("_AM_PDD_CCATEGORY_MODIFY", "Modify Category");
	define("_AM_PDD_CCATEGORY_MOVE", "Move Category Files");
	define("_AM_PDD_CCATEGORY_MODIFY_TITLE", "Category Title:");
	define("_AM_PDD_CCATEGORY_MODIFY_FAILED", "Failed Moving Files: Cannot move to this Category");
	define("_AM_PDD_CCATEGORY_MODIFY_FAILEDT", "Failed Moving Files: Cannot find this Category");
	define("_AM_PDD_CCATEGORY_MODIFY_MOVED", "Files Moved and Category Deleted");
	define("_AM_PDD_CCATEGORY_CREATED", "New Category Created and Database Updated Successfully");
	define("_AM_PDD_CCATEGORY_MODIFIED", "Selected Category Modified and Database Updated Successfully");
	define("_AM_PDD_CCATEGORY_DELETED", "Selected Category Deleted and Database Updated Successfully");
	define("_AM_PDD_CCATEGORY_AREUSURE", "WARNING: Are you sure you want to delete this Category and ALL its Files and Comments?");
	define("_AM_PDD_CCATEGORY_NOEXISTS", "You must create a Category before you can add a new file");
	define("_AM_PDD_FCATEGORY_GROUPPROMPT", "Category Access Permissions:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select user groups who will have access to this Category.</span></div>");
	define("_AM_PDD_FCATEGORY_TITLE", "Category Title:");
	define("_AM_PDD_FCATEGORY_WEIGHT", "Category Weight:");
	define("_AM_PDD_FCATEGORY_SUBCATEGORY", "Set As Sub-Category:");
	define("_AM_PDD_FCATEGORY_CIMAGE", "Select Category Image:");
	define("_AM_PDD_FCATEGORY_DESCRIPTION", "Set Category Description:");
	/*
	* Index page Defines
	*/
	define("_AM_PDD_IPAGE_UPDATED", "Index Page Modified and Database Updated Successfully!");
	define("_AM_PDD_IPAGE_INFORMATION", "Index Page Information");
	define("_AM_PDD_IPAGE_MODIFY", "Modify Index Page");
	define("_AM_PDD_IPAGE_CIMAGE", "Select Index Image:");
	define("_AM_PDD_IPAGE_CTITLE", "Index Title:");
	define("_AM_PDD_IPAGE_CHEADING", "Index Heading:");
	define("_AM_PDD_IPAGE_CHEADINGA", "Index Heading Alignment:");
	define("_AM_PDD_IPAGE_CFOOTER", "Index Footer:");
	define("_AM_PDD_IPAGE_CFOOTERA", "Index Footer Alignment:");
	define("_AM_PDD_IPAGE_CLEFT", "Align Left");
	define("_AM_PDD_IPAGE_CCENTER", "Align Center");
	define("_AM_PDD_IPAGE_CRIGHT", "Align Right");
	/*
	*  Permissions defines
	*/
	define("_AM_PDD_PERM_MANAGEMENT", "Permissions Management");
	define("_AM_PDD_PERM_PERMSNOTE", "<div><b>NOTE:</b> Please be aware that even if you&#8217ve set correct viewing permissions here, a group might not see the articles or blocks if you don&#8217t also grant that group permissions to access the module. To do that, go to <b>System admin > Groups</b>, choose the appropriate group and click the checkboxes to grant its members the access.</div>");
	define("_AM_PDD_PERM_CPERMISSIONS", "Category Permissions");
	define("_AM_PDD_PERM_CSELECTPERMISSIONS", "Select categories that each group is allowed to view");
	define("_AM_PDD_PERM_CNOCATEGORY", "Cannot set permission's: No Categories's have been created yet!");
	define("_AM_PDD_PERM_FPERMISSIONS", "File Permissions");
	define("_AM_PDD_PERM_FNOFILES", "Cannot set permission's: No files have been created yet!");
	define("_AM_PDD_PERM_FSELECTPERMISSIONS", "Select the files that each group is allowed to view");
	/*
	* Upload defines
	*/
	define("_AM_PDD_DOWN_IMAGEUPLOAD", "Image successfully uploaded to server destination");
	define("_AM_PDD_DOWN_NOIMAGEEXIST", "Error: No file was selected for uploading.  Please try again!");
	define("_AM_PDD_DOWN_IMAGEEXIST", "Image already exists in upload area!");
	define("_AM_PDD_DOWN_FILEDELETED", "File has been deleted.");
	define("_AM_PDD_DOWN_FILEERRORDELETE", "Error deleting File: File not found on server.");
	define("_AM_PDD_DOWN_NOFILEERROR", "Error deleting File: No File Selected For Deleting.");
	define("_AM_PDD_DOWN_DELETEFILE", "WARNING: Are you sure you want to delete this Image file?");
	define("_AM_PDD_DOWN_IMAGEINFO", "Server Status");
	define("_AM_PDD_DOWN_SPHPINI", "<b>Information taken from PHP ini File:</b>");
	define("_AM_PDD_DOWN_SAFEMODESTATUS", "Safe Mode Status: ");
	define("_AM_PDD_DOWN_REGISTERGLOBALS", "Register Globals: ");
	define("_AM_PDD_DOWN_SERVERUPLOADSTATUS", "Server Uploads Status: ");
	define("_AM_PDD_DOWN_MAXUPLOADSIZE", "Max Upload Size Permitted: ");
	define("_AM_PDD_DOWN_MAXPOSTSIZE", "Max Post Size Permitted: ");
	define("_AM_PDD_DOWN_MAXEXECTIME", "Max Time for running scripts:");
	define("_AM_PDD_DOWN_SAFEMODEPROBLEMS", " (This May Cause Problems)");
	define("_AM_PDD_DOWN_GDLIBSTATUS", "GD Library Support: ");
	define("_AM_PDD_DOWN_GDLIBVERSION", "GD Library Version: ");
	define("_AM_PDD_DOWN_GDON", "<b>Enabled</b> (Thumbs Nails Available)");
	define("_AM_PDD_DOWN_GDOFF", "<b>Disabled</b> (No Thumb Nails Available)");
	define("_AM_PDD_DOWN_OFF", "<b>OFF</b>");
	define("_AM_PDD_DOWN_ON", "<b>ON</b>");
	define("_AM_PDD_DOWN_CATIMAGE", "Category Images");
	define("_AM_PDD_DOWN_SCREENSHOTS", "Screenshot Images");
	define("_AM_PDD_DOWN_MAINIMAGEDIR", "Main images");
	define("_AM_PDD_DOWN_FCATIMAGE", "Category Image Path");
	define("_AM_PDD_DOWN_FSCREENSHOTS", "Screenshot Image Path");
	define("_AM_PDD_DOWN_FMAINIMAGEDIR", "Main image Path");
	define("_AM_PDD_DOWN_FUPLOADIMAGETO", "Upload Image: ");
	define("_AM_PDD_DOWN_FUPLOADPATH", "Upload Path: ");
	define("_AM_PDD_DOWN_FUPLOADURL", "Upload URL: ");
	define("_AM_PDD_DOWN_FOLDERSELECTION", "Select Upload Destination:");
	define("_AM_PDD_DOWN_FSHOWSELECTEDIMAGE", "Display Selected Image:");
	define("_AM_PDD_DOWN_FUPLOADIMAGE", "Upload New Image to Selected Destination:");

	// Main Index defines
	define("_AM_PDD_MINDEX_DOWNSUMMARY", "Module Admin Summary");
	define("_AM_PDD_MINDEX_PUBLISHEDDOWN", "Published Files:");
	define("_AM_PDD_MINDEX_AUTOPUBLISHEDDOWN", "Auto Published Files:");
	define("_AM_PDD_MINDEX_AUTOEXPIRE", "Auto Expire Files:");
	define("_AM_PDD_MINDEX_EXPIRED", "Expired Files:");
	define("_AM_PDD_MINDEX_OFFLINEDOWN", "Offline Files:");
	define("_AM_PDD_MINDEX_ID", "ID");
	define("_AM_PDD_MINDEX_TITLE", "File Title");
	define("_AM_PDD_MINDEX_POSTER", "Poster");
	define("_AM_PDD_MINDEX_SUBMITTED", "Submission Date");
	define("_AM_PDD_MINDEX_ONLINESTATUS", "Online Status");
	define("_AM_PDD_MINDEX_PUBLISHED", "Published");
	define("_AM_PDD_MINDEX_ACTION", "Action");
	define("_AM_PDD_MINDEX_NODOWNLOADSFOUND", "NOTICE: There are no files that match this criteria");
	define("_AM_PDD_MINDEX_PAGE", "<b>Page:<b> ");
	define('_AM_PDD_MINDEX_PAGEINFOTXT', '<ul><li>PD-Downloads main page details.</li><li>You can easily change the image logo, heading, main index header and footer text to suit your own look</li></ul><br /><br />Note: The Logo image choosen will be used throughout PD-Downloads.');
	define("_AM_PDD_MINDEX_DOWNSEC","in our downloadsection");
	define("_MD_PDD_NUMBYTES", "%s bytes");
	define('_MD_PDD_AVAILABLE','available');
	define('_MD_PDD_NOTAVAILABLE','<font color="red">not available</font>');
	define("_MD_PDD_CREATEMANUAL", "<b>ATTENTION - Safe Mode is on</B>, you have to create the folder yourself.");
	define("_MD_PDD_CHMODMANUAL","<b>ATTENTION - Safe Mode is on</B>, you have to set the permission yourself.");
	define('_MD_PDD_NOTWRITABLE','<font color="red">not writable</font>');
	define('_MD_PDD_UPLOADPATH','%s will be stored in this folder');
	define('_MD_PDD_UPLOADPATHINFO','Information about the upload-paths');
	define('_MD_PDD_CREATETHEDIR','create');
	define('_MD_PDD_SETMPERM','set permission');
	define('_MD_PDD_DIRCREATED','The folder was created');
	define('_MD_PDD_DIRNOTCREATED','The folder could not be created');
	define('_MD_PDD_PERMSET','Permission was set');
	define('_MD_PDD_PERMNOTSET','Permission could not be set');
	define("_AM_PDD_UPLOADS","Uploads");

	// Submitted Files
	define("_AM_PDD_SUB_SUBMITTEDFILES", "Submitted Files");
	define("_AM_PDD_SUB_FILESWAITINGINFO", "Waiting Files Information");
	define("_AM_PDD_SUB_FILESWAITINGVALIDATION", "Files Waiting Validation: ");
	define("_AM_PDD_SUB_APPROVEWAITINGFILE", "<b>Approve</b> new file information without validation.");
	define("_AM_PDD_SUB_EDITWAITINGFILE", "<b>Edit</b> new file information and then approve.");
	define("_AM_PDD_SUB_DELETEWAITINGFILE", "<b>Delete</b> the new file information.");
	define("_AM_PDD_SUB_NOFILESWAITING", "There are no files that match this critera");
	define("_AM_PDD_SUB_NEPDILECREATED", "New File Data Created and Database Updated Successfully");
	define("_AM_PDD_SUB_WANTTOAPPROVE", "Do you really want to approve the download without checking it before?");
	// Mimetypes
	define("_AM_PDD_MIME_ID", "ID");
	define("_AM_PDD_MIME_EXT", "EXT");
	define("_AM_PDD_MIME_NAME", "Application Type");
	define("_AM_PDD_MIME_ADMIN", "Admin");
	define("_AM_PDD_MIME_USER", "User");
	// Mimetype Form
	define("_AM_PDD_MIME_CREATEF", "Create Mimetype");
	define("_AM_PDD_MIME_MODIFYF", "Modify Mimetype");
	define("_AM_PDD_MIME_EXTF", "File Extension:");
	define("_AM_PDD_MIME_NAMEF", "Application Type/Name:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter application associated with this extension.</span></div>");
	define("_AM_PDD_MIME_TYPEF", "Mimetypes:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter each mimetype associated with the file extension. Each mimetype must be seperated with a space.</span></div>");
	define("_AM_PDD_MIME_ADMINF", "Allowed Admin Mimetype");
	define("_AM_PDD_MIME_ADMINFINFO", "<b>Mimetypes that are available for Admin uploads:</b>");
	define("_AM_PDD_MIME_USERF", "Allowed User Mimetype");
	define("_AM_PDD_MIME_USERFINFO", "<b>Mimetypes that are available for User uploads:</b>");
	define("_AM_PDD_MIME_NOMIMEINFO", "No mimetypes selected.");
	define("_AM_PDD_MIME_FINDMIMETYPE", "Find New Mimetype:");
	define("_AM_PDD_MIME_EXTFIND", "Search File Extension:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter file extension you wish to search.</span></div>");
	define("_AM_PDD_MIME_INFOTEXT", "<ul><li>New mimetypes can be created, edit or deleted easily via this form.</li>
	<li>Search for a new mimetypes via an external website.</li>
	<li>View displayed mimetypes for Admin and User uploads.</li>
	<li>Change mimetype upload status.</li></ul>
	");

	// Mimetype Buttons
	define("_AM_PDD_MIME_CREATE", "Create");
	define("_AM_PDD_MIME_CLEAR", "Reset");
	define("_AM_PDD_MIME_CANCEL", "Cancel");
	define("_AM_PDD_MIME_MODIFY", "Modify");
	define("_AM_PDD_MIME_DELETE", "Delete");
	define("_AM_PDD_MIME_FINDIT", "Get Extension!");
	// Mimetype Database
	define("_AM_PDD_MIME_DELETETHIS", "Delete Selected Mimetype?");
	define("_AM_PDD_MIME_MIMEDELETED", "Mimetype %s has been deleted");
	define("_AM_PDD_MIME_CREATED", "Mimetype Information Created");
	define("_AM_PDD_MIME_MODIFIED", "Mimetype Information Modified");
	// Vote Information
	define("_AM_PDD_VOTE_RATINGINFOMATION", "Voting Information");
	define("_AM_PDD_VOTE_TOTALVOTES", "Total votes: ");
	define("_AM_PDD_VOTE_REGUSERVOTES", "Registered User Votes: %s");
	define("_AM_PDD_VOTE_ANONUSERVOTES", "Anonymous User Votes: %s");
	define("_AM_PDD_VOTE_USER", "User");
	define("_AM_PDD_VOTE_IP", "IP Address");
	define("_AM_PDD_VOTE_USERAVG", "Average User Rating");
	define("_AM_PDD_VOTE_TOTALRATE", "Total Ratings");
	define("_AM_PDD_VOTE_DATE", "Submitted");
	define("_AM_PDD_VOTE_RATING", "Rating");
	define("_AM_PDD_VOTE_NOREGVOTES", "No Registered User Votes");
	define("_AM_PDD_VOTE_NOUNREGVOTES", "No Unregistered User Votes");
	define("_AM_PDD_VOTE_VOTEDELETED", "Vote data deleted.");
	define("_AM_PDD_VOTE_ID", "ID");
	define("_AM_PDD_VOTE_FILETITLE", "File Title");
	define("_AM_PDD_VOTE_DISPLAYVOTES", "Voting Data Information");
	define("_AM_PDD_VOTE_NOVOTES", "No User Votes to display");
	define("_AM_PDD_VOTE_DELETE", "No User Votes to display");
	define("_AM_PDD_VOTE_DELETEDSC", "<b>Deletes</b> the chosen vote information from the database.");
	define("_AM_PDD_VOTEDELETED", "The vote was deleted successfully.");

	// Modifications
	define("_AM_PDD_MOD_TOTMODREQUESTS", "Total Modification Requests: ");
	define("_AM_PDD_MOD_MODREQUESTS", "Modified Files");
	define("_AM_PDD_MOD_MODREQUESTSINFO", "Modified Files Information");
	define("_AM_PDD_MOD_MODID", "ID");
	define("_AM_PDD_MOD_MODTITLE", "Title");
	define("_AM_PDD_MOD_MODPOSTER", "Original Poster: ");
	define("_AM_PDD_MOD_DATE", "Submitted");
	define("_AM_PDD_MOD_NOMODREQUEST", "There are no requests that match this critera");
	define("_AM_PDD_MOD_TITLE", "Download Title: ");
	define("_AM_PDD_MOD_LID", "Download ID: ");
	define("_AM_PDD_MOD_CID", "Category: ");
	define("_AM_PDD_MOD_URL", "Download Url: ");
	define("_AM_PDD_MOD_SIZE", "Download Size: ");
	define("_AM_PDD_MOD_PUBLISHER", "Publisher: ");
	define("_AM_PDD_MOD_FEATURES", "Key Features: ");
	define("_AM_PDD_MOD_FORUMID", "Forum: ");
	define("_AM_PDD_MOD_DHISTORY", "Download History: ");
	define("_AM_PDD_MOD_SCREENSHOT", "Screenshot Image: ");
	define("_AM_PDD_MOD_HOMEPAGE", "Home Page: ");
	define("_AM_PDD_MOD_HOMEPAGETITLE", "Home Page Title: ");
	define("_AM_PDD_MOD_VERSION", "Version: ");
	define("_AM_PDD_MOD_SHOTIMAGE", "Screenshot Image: ");
	define("_AM_PDD_MOD_FILESIZE", "File Size: ");
	define("_AM_PDD_MOD_PLATFORM", "Software Platform: ");
	define("_AM_PDD_MOD_DESCRIPTION", "Description: ");
	define("_AM_PDD_MOD_REQUIREMENTS", "Requirements: ");
	define("_AM_PDD_MOD_MODIFYSUBMITTER", "Submitter: ");
	define("_AM_PDD_MOD_MODIFYSUBMIT", "Submitter");
	define("_AM_PDD_MOD_PROPOSED", "Proposed Download Details");
	define("_AM_PDD_MOD_ORIGINAL", "Orginal Download Details");
	define("_AM_PDD_MOD_REQDELETED", "Modification request removed from the database");
	define("_AM_PDD_MOD_REQUPDATED", "Selected Download Modified and Database Updated Successfully");
	define('_AM_PDD_MOD_VIEW','View');

	//File management
	define("_AM_PDD_FILE_ID", "File ID: ");
	define("_AM_PDD_FILE_IP", "Uploaders IP Address: ");
	define("_AM_PDD_FILE_ALLOWEDAMIME", "<div style='padding-top: 4px; padding-bottom: 4px;'><b>Allowed Admin File Extensions</b>:</div>");
	define("_AM_PDD_FILE_MODIFYFILE", "Modify File Information");
	define("_AM_PDD_FILE_CREATENEPDILE", "Create New File");
	define("_AM_PDD_FILE_TITLE", "File Title: ");
	define("_AM_PDD_FILE_DLURL", "File URL: ");
	define("_AM_PDD_FILE_MIRRORURL", "File Mirror: ");
	define("_AM_PDD_FILE_DESCRIPTION", "File Description: ");
	define("_AM_PDD_FILE_DUPLOAD", " Upload File:");
	define("_AM_PDD_FILE_DUPLOADSIZE", "<br /><br />Allowed filesize: ");
	define("_AM_PDD_FILE_CATEGORY", "Select Category: ");
	define("_AM_PDD_FILE_HOMEPAGETITLE", "Home Page Title: ");
	define("_AM_PDD_FILE_HOMEPAGE", "Home Page: ");
	define("_AM_PDD_FILE_SIZE", "File Size in KB: ");
	define("_AM_PDD_FILE_VERSION", "File Version: ");
	define("_AM_PDD_FILE_PUBLISHER", "File Publisher: ");
	define("_AM_PDD_FILE_PLATFORM", "Software Platform: ");
	define("_AM_PDD_FILE_KEYFEATURES", "Key Features:<br /><br /><span style='font-weight: normal;'>Seperate each Key Feature with a <b>#</b></span>");
	define("_AM_PDD_FILE_DELEDITMESS", "Delete Broken Report?<br /><br /><span style='font-weight: normal;'>When you choose <b>YES</b> the Broken Report will automatically deleted and you confirm that the download now works again.</span>");
	define("_AM_PDD_FILE_HISTORY", "Download History Edit:<br /><br /><span style='font-weight: normal;'>Add New Download History and only use this field to if you need to edit the previous history.</span>");
	define("_AM_PDD_FILE_HISTORYD", "Add New Download History:<br /><br /><span style='font-weight: normal;'>The version Number and date will be added automatically</span>");
	define("_AM_PDD_FILE_HISTORYVERS", "<b>Version: </b>");
	define("_AM_PDD_FILE_HISTORDATE", " <b>Updated:</b> ");
	define("_AM_PDD_FILE_FILESSTATUS", " Set Download offline?<br /><br /><span style='font-weight: normal;'>Download will not be viewable to all users.</span>");
	define("_AM_PDD_FILE_SETASUPDATED", " Set Download Status as Updated?<br /><br /><span style='font-weight: normal;'>Download will Display updated icon.</span>");
	define("_AM_PDD_FILE_RESETCALLS", "Reset download-counter?");
	define("_AM_PDD_FILE_SHOTIMAGE", "Select Screenshot Image: ");
	define("_AM_PDD_FILE_DISCUSSINFORUM", "Add Discuss in this Forum?");
	define("_AM_PDD_FILE_PUBLISHDATE", "File Publish Date:");
	define("_AM_PDD_FILE_EXPIREDATE", "File Expire Date:");
	define("_AM_PDD_FILE_CLEARPUBLISHDATE", "<br /><br />Remove Publish date:");
	define("_AM_PDD_FILE_CLEAREXPIREDATE", "<br /><br />Remove Expire date:");
	define("_AM_PDD_FILE_PUBLISHDATESET", " Publish date set: ");
	define("_AM_PDD_FILE_SETDATETIMEPUBLISH", " Set the date/time of publish");
	define("_AM_PDD_FILE_SETDATETIMEEXPIRE", " Set the date/time of expire");
	define("_AM_PDD_FILE_SETPUBLISHDATE", "<b>Set Publish Date: </b>");
	define("_AM_PDD_FILE_SETNEWPUBLISHDATE", "<b>Set New Publish Date: </b><br />Published:");
	define("_AM_PDD_FILE_SETPUBDATESETS", "<b>Publish Date Set: </b><br />Publishes On Date:");
	define("_AM_PDD_FILE_EXPIREDATESET", " Expire date set: ");
	define("_AM_PDD_FILE_SETEXPIREDATE", "<b>Set Expire Date: </b>");
	define("_AM_PDD_FILE_MUSTBEVALID", "Screenshot image must be a valid image file under %s directory (ex. shot.gif). Leave it blank if there is no image file.");
	define("_AM_PDD_FILE_EDITAPPROVE", "Approve download:");
	define("_AM_PDD_FILE_NEPDILEUPLOAD", "New File Created and Database Updated Successfully");
	define("_AM_PDD_FILE_FILEMODIFIEDUPDATE", "Selected File Modified and Database Updated Successfully");
	define("_AM_PDD_FILE_REALLYDELETEDTHIS", "Really delete the selected file?");
	define("_AM_PDD_FILE_FILEWASDELETED", "File %s successfully removed from the database!");
	define("_AM_PDD_FILE_USE_UPLOAD_TITLE", " Use upload filename for file title.");
	define("_AM_PDD_FILE_FILEAPPROVED", "File Approved and Database Updated Successfully");
	define("_AM_PDD_FILE_CREATENEWSSTORY", "<b>Create News Story From Download</b>");
	define("_AM_PDD_FILE_SUBMITNEWS", "Submit New file as News item?");
	define("_AM_PDD_FILE_NEWSCATEGORY", "Select News Category to submit News:");
	define("_AM_PDD_FILE_NEWSTITLE", "News Title:<div style='padding-top: 4px; padding-bottom: 4px;'><span style='font-weight: normal;'>Leave Blank to use File Title</span></div>");
	define('_AM_PDD_ONETHING', 'Its only possible to set one News in one News-Module at the same time!');
	define("_AM_PDD_FILE_SELCAT","You have to select a categorie!");
	define("_AM_PDD_FILE_GROUPPROMPT", "Download Access Permissions:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select user groups who will have access to this Download.</span></div>");

	/*
	* Broken downloads defines
	*/
	define("_AM_PDD_SBROKENSUBMIT", "Broken: ");
	define("_AM_PDD_BROKEN_FILE", "Broken Reports");
	define("_AM_PDD_BROKEN_FILEIGNORED", "Broken report ignored and successfully removed from the database!");
	define("_AM_PDD_BROKEN_NOWACK", "Acknowledged status changed and database updated!");
	define("_AM_PDD_BROKEN_NOWCON", "Status has been set to *in proceed*, you will be forwarded to the Edit-Download Page.");
	define("_AM_PDD_BROKEN_REPORTINFO", "Broken Report Information");
	define("_AM_PDD_BROKEN_REPORTSNO", "Broken Reports Waiting:");
	define("_AM_PDD_BROKEN_IGNOREDESC", "<b>Ignores</b> the report and only deletes the broken file report.");
	define("_AM_PDD_BROKEN_DELETEDESC", "<b>Deletes</b> the reported download data and broken file reports for the file.");
	define("_AM_PDD_BROKEN_EDITDESC", "<b>Edit</b> the download to fix the problem.");
	define("_AM_PDD_BROKEN_ACKDESC", "<b>In proceed</b> The download has been edited but its not clear if it really works.");
	define("_AM_PDD_BROKEN_CONFIRMDESC", "<b>Confirmed</b> Set confirmed state of broken file report.");

	define("_AM_PDD_BROKEN_ID", "ID");
	define("_AM_PDD_BROKEN_TITLE", "Title");
	define("_AM_PDD_BROKEN_REPORTER", "Reporter");
	define("_AM_PDD_BROKEN_FILESUBMITTER", "Submitter");
	define("_AM_PDD_BROKEN_DATESUBMITTED", "Submit Date");
	define("_AM_PDD_BROKEN_ACTION", "Action");
	define("_AM_PDD_BROKEN_NOFILEMATCH", "There are no Broken reports that match this critera");
	define("_AM_PDD_BROKENFILEDELETED", "Download removed from database and broken report removed");

	/*
	* About defines
	*/
	define("_AM_PDD_BY", "by");

	/*
	* Upgrade and Import Tool defines
	*/
	define("_UI_PDD_INFO", "Information");
	define('_UI_PDD_INFOTEXT', '<b><u>UPGRADE:</u></b> <ul><li>Data from the selected Module will be imported in this module.</li>
<li>The selected module will be automatically deactivated and deinstalled.</li><li>After that you only have to delete the selected module from your webserver.</li></ul><br>
<b><u>IMPORT:</u></b><ul><li>Data from the selected Module will be imported in this module.</li><li>No changes will be made on the selected module and you can use it further.</li></ul><br>
<b>You should only use the Upgrade-Function when you 100% know what you are doing!</b>');
	define("_UI_PDD_SELMODULE","Module selection");
	define("_UI_PDD_CHOOSEMODULE","Select a module:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select the module you want to upgrade or import data from.</span></div>");
	define("_UI_PDD_ACTUALMODUL", "Data will be stored into this module:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Data from the above selected module will be stored into this module.</span></div>");
	define("_UI_PDD_UPGRADE", "Upgrade");
	define("_UI_PDD_IMPORT", "Import");
	define("_UI_PDD_SUREUPGADE", "ATTENTION: Do you really want to Upgrade?<br>The selected module will be deinstalled and all stored data from the selected module will be deleted.");
	define("_UI_PDD_SUREIMPORT", "ATTENTION: All saved data from this module will be deleted.");
	define("_UI_PDD_PART", "working ...");
	define("_UI_PDD_OPTIONS", "Additional options:");
	define("_UI_PDD_WANTCOM", "Take over comments");
	define("_UI_PDD_WANTNOT", "Take over notification settings");
	define("_UI_PDD_WANTPERM", "Take over permissions settings<br><small>(Only works with WF- or PD-Downloads)</small>");

	//block defines
	define("_AM_PDD_BADMIN","Block Administration");
	define("_AM_PDD_BLKDESC","Description");
	define("_AM_PDD_TITLE","Title");
	define("_AM_PDD_SIDE","Alignment");
	define("_AM_PDD_WEIGHT","Weight");
	define("_AM_PDD_VISIBLE","Visible");
	define("_AM_PDD_ACTION","Action");
	define("_AM_PDD_SBLEFT","Left");
	define("_AM_PDD_SBRIGHT","Right");
	define("_AM_PDD_CBLEFT","Center Left");
	define("_AM_PDD_CBRIGHT","Center Right");
	define("_AM_PDD_CBCENTER","Center Middle");
	define("_AM_PDD_ACTIVERIGHTS","Active Rights");
	define("_AM_PDD_ACCESSRIGHTS","Access Rights");

	//image admin icon
	define("_AM_PDD_ICO_EDIT","Edit This Item");
	define("_AM_PDD_ICO_DELETE","Delete This Item");
	define("_AM_PDD_ICO_ONLINE","Online");
	define("_AM_PDD_ICO_OFFLINE","Offline");
	define("_AM_PDD_ICO_APPROVED","Approved");
	define("_AM_PDD_ICO_NOTAPPROVED","Not Approved");

	define("_AM_PDD_ICO_LINK","Related Link");
	define("_AM_PDD_ICO_URL","Add Related URL");
	define("_AM_PDD_ICO_ADD","Add");
	define("_AM_PDD_ICO_APPROVE","Approve");
	define("_AM_PDD_ICO_STATS","Stats");

	define("_AM_PDD_ICO_IGNORE","Ignore");
	define("_AM_PDD_ICO_ACK","Broken Report Acknowledged");
	define("_AM_PDD_ICO_REPORT","Acknowledge Broken Report?");
	define("_AM_PDD_ICO_CONFIRM","Broken Report Confirmed");
	define("_AM_PDD_ICO_CONBROKEN","Confirm Broken Report?");

	/*
	* Statistic defines
	*/
	define("_AM_PDD_VIEW","Calls");
	define("_AM_PDD_ENTRIES", "Entries");
	define("_AM_PDD_EXPIRED", "Expired Entries");
	define("_AM_PDD_USENDFROM", "Unique creator");
	define("_AM_PDD_TOTAL", "Totals");
	define("_AM_PDD_DLSTAT", "Downloads statistics");
	define("_AM_PDD_DLSTAT1", "Most called downloads");
	define("_AM_PDD_DLSTAT2", "Less called downloads");
	define("_AM_PDD_DLSTAT3", "Best rated downloads");
	define("_AM_PDD_CREATERSTAT", "creators statistics");
	define("_AM_PDD_CREATERSTAT1", "Most called creators");
	define("_AM_PDD_CREATERSTAT2", "Best rated creators");
	define("_AM_PDD_CREATERSTAT3", "Biggest contributors");
	define("_AM_PDD_CREATERSTAT4", "Number of entries");
}
?>
