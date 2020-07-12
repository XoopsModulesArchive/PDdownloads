<?php
/**
 * $Id: main.php v 1.22 02 july 2004 Liquid Exp $
 * Module: PD-Downloads
 * Version: v1.0
 * Release Date: 04. März 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( '_MD_PDD_NODOWNLOAD' ) ) {

	define("_MD_PDD_NODOWNLOAD", "This download does not exist!");
	define("_MD_PDD_NOCAT", "This category does not exist!");
	define("_MD_PDD_NOUSER", "This user does not exist!");

	define("_MD_PDD_SUBCATLISTING", "Category Listing");
	define("_MD_PDD_ISADMINNOTICE", "Webmaster: There is a problem with this image.");
	define("_MD_PDD_THANKSFORINFO", "Thank-you for your submission. You will be notified once your request has be approved by the webmaster.");
	define("_MD_PDD_ISAPPROVED", "Thank-you for your submission. Your request has been approved and will now appear in our listing.");
	define("_MD_PDD_THANKSFORHELP", "Thank-you for helping to maintain this directory's integrity.");
	define("_MD_PDD_FORSECURITY", "For security reasons your user name and IP address will also be temporarily recorded.");
	define("_MD_PDD_NOPERMISETOLINK", "This file doesn't belong to the site you came from <br /><br />Please e-mail the webmaster of the site you came from and tell him:   <br /><b>NOT TO LEECH OTHER SITES LINKS!!</b> <br /><br /><b>Definition of a Leecher:</b> One who is to lazy to link from his own server or steals other peoples hard work and makes it look like his own <br /><br />  Your IP address <b>has been logged</b>.");
	define("_MD_PDD_DESCRIPTION", "Description");
	define("_MD_PDD_SUBMITCATHEAD", "Submit download Form");
	define("_MD_PDD_MAIN", "HOME");
	define("_AM_PDD_MYTOTAL", "Total");
	define("_MD_PDD_POPULAR", "Popular");
	define("_MD_PDD_NEWTHISWEEK", "New this week");
	define("_MD_PDD_UPTHISWEEK", "Updated this week");
	define("_MD_PDD_POPULARITYLTOM", "Popularity (Least to Most Hits)");
	define("_MD_PDD_POPULARITYMTOL", "Popularity (Most to Least Hits)");
	define("_MD_PDD_TITLEATOZ", "Title (A to Z)");
	define("_MD_PDD_TITLEZTOA", "Title (Z to A)");
	define("_MD_PDD_DATEOLD", "Date (Old Files Listed First)");
	define("_MD_PDD_DATENEW", "Date (New Files Listed First)");
	define("_MD_PDD_RATINGLTOH", "Rating (Lowest Score to Highest Score)");
	define("_MD_PDD_RATINGHTOL", "Rating (Highest Score to Lowest Score)");
	define("_MD_PDD_DESCRIPTIONC", "Description: ");
	define("_MD_PDD_CATEGORYC", "Category: ");
	define("_MD_PDD_VERSION", "Version");
	define("_MD_PDD_SUBMITDATE", "Released");
	define("_MD_PDD_DLTIMES", "Downloaded %s times");
	define("_MD_PDD_FILESIZE", "File Size");
	define("_MD_PDD_SUPPORTEDPLAT", "Platform");
	define("_MD_PDD_HOMEPAGE", "Home Page");
	define("_MD_PDD_PUBLISHERC", "Publisher: ");
	define("_MD_PDD_RATINGC", "Rating: ");
	define("_MD_PDD_ONEVOTE", "1 Vote");
	define("_MD_PDD_NUMVOTES", "%s Votes");
	define("_MD_PDD_RATETHISFILE", "Rate Resource");
	define("_MD_PDD_DOWNLOADHITS", "Downloads: ");
	define("_MD_PDD_MODIFY", "Modify");
	define("_MD_PDD_REPORTBROKEN", "Report Broken");
	define("_MD_PDD_BROKENREPORT", "Report Broken Resource");
	define("_MD_PDD_SUBMITBROKEN", "Submit");
	define("_MD_PDD_BEFORESUBMIT", "Before submitting a broken resource request, please check that the actual source of the file you intend reporting broken, is no longer there and that the website is not temporally down.");
	define("_MD_PDD_TELLAFRIEND", "Recommend");
	define("_MD_PDD_EDIT", "Edit");
	define("_MD_PDD_THEREARE", "There are <b>%s</b> <i>Categories</i> and <b>%s</b> <i>Downloads</i> listed");
	define("_MD_PDD_THEREIS", "There is <b>%s</b> <i>Category</i> and <b>%s</b> <i>Downloads</i> listed");
	define("_MD_PDD_LATESTLIST", "Latest Listings");
	define("_MD_PDD_FILETITLE", "Download Title: ");
	define("_MD_PDD_DLURL", "Download URL: ");
	define("_MD_PDD_HOMEPAGEC", "Home Page: ");
	define("_MD_PDD_UPLOAD_FILEC", "Upload File: ");
	define("_MD_PDD_UPLOAD_FILESIZE", "<br /><br />Allowed filesize: ");
	define("_MD_PDD_VERSIONC", "Version: ");
	define("_MD_PDD_FILESIZEC", "File Size in KB: ");
	define("_AM_PDD_SHOTIMAGE", "Screenshot: ");
	define("_AM_PDD_UPLOADSHOTIMAGE", "Upload screenshot: ");
	define("_MD_PDD_NUMBYTES", "%s bytes");
	define("_MD_PDD_PLATFORMC", "Platform: ");
	define("_MD_PDD_NOTSPECIFIED", "Not Specified");
	define("_MD_PDD_PUBLISHER", "Publisher");
	define("_MD_PDD_UPDATEDON", "Updated On");
	define("_MD_PDD_VIEWDETAILS", "View Full Details");
	define("_MD_PDD_OPTIONS", 'Options: ');
	define("_MD_PDD_NOTIFYAPPROVE", 'Notify me when this file is approved');
	define("_MD_PDD_VOTEAPPRE", "Your vote is appreciated.");
	define("_MD_PDD_THANKYOU", "Thank you for taking the time to vote here at %s"); // %s is your site name
	define("_MD_PDD_VOTEONCE", "Please do not vote for the same resource more than once.");
	define("_MD_PDD_RATINGSCALE", "The scale is 1 - 10, with 1 being poor and 10 being excellent.");
	define("_MD_PDD_BEOBJECTIVE", "Please be objective, if everyone receives a 1 or a 10, the ratings aren't very useful.");
	define("_MD_PDD_DONOTVOTE", "Do not vote for your own resource.");
	define("_MD_PDD_RATEIT", "Rate It!");
	define("_MD_PDD_INTFILEFOUND", "Here is a good file to download at %s"); // %s is your site name
	define("_MD_PDD_RANK", "Rank");
	define("_MD_PDD_CATEGORY", "Category");
	define("_MD_PDD_HITS", "Hits");
	define("_MD_PDD_RATING", "Rating");
	define("_MD_PDD_VOTE", "Vote");
	define("_MD_PDD_SORTBY", "Sort by:");
	define("_MD_PDD_TITLE", "Title");
	define("_MD_PDD_DATE", "Date");
	define("_MD_PDD_POPULARITY", "Popularity");
	define("_MD_PDD_TOPRATED", "Rating");
	define("_MD_PDD_CURSORTBY", "Files currently sorted by: %s");
	define("_MD_PDD_CANCEL", "Cancel");
	define("_MD_PDD_ALREADYREPORTED", "You have already submitted a broken report for this resource.");
	define("_MD_PDD_MUSTREGFIRST", "Sorry, you don't have the permission to perform this action.<br />Please register or login first!");
	define("_MD_PDD_NORATING", "No rating selected.");
	define("_MD_PDD_CANTVOTEOWN", "You cannot vote on the resource you submitted.<br />All votes are logged and reviewed.");
	define("_MD_PDD_SUBMITDOWNLOAD", "Submit Download");
	define("_MD_PDD_SUB_SNEWMNAMEDESC", "<ul><li>All new Downloads's are subject to validation and may take up to 24 hours before they appear in our listing.</li><li>We reserve the rights to refuse any submitted download or change the content without approval.</li></ul>");
	define("_MD_PDD_MAINLISTING", "Main Category Listings");
	define("_MD_PDD_LASTWEEK", "Last Week");
	define("_MD_PDD_LAST30DAYS", "Last 30 Days");
	define("_MD_PDD_1WEEK", "1 Week");
	define("_MD_PDD_2WEEKS", "2 Weeks");
	define("_MD_PDD_30DAYS", "30 Days");
	define("_MD_PDD_SHOW", "Show");
	define("_MD_PDD_DAYS", "days");
	define("_MD_PDD_NEWDOWNLOADS", "New Downloads");
	define("_MD_PDD_TOTALNEWDOWNLOADS", "Total New Downloads");
	define("_MD_PDD_DTOTALFORLAST", "Total new downloads for last");
	define("_MD_PDD_AGREE", "I Agree");
	define("_MD_PDD_DOYOUAGREE", "Do you agree to the above terms?");
	define("_MD_PDD_DISCLAIMERAGREEMENT", "Disclaimer");
	define("_MD_PDD_DUPLOADSCRSHOT", "Upload Screenshot Image:");
	define("_MD_PDD_RESOURCEID", "Resource id#: ");
	define("_MD_PDD_REPORTER", "Original Reporter: ");
	define("_MD_PDD_DATEREPORTED", "Date Reported: ");
	define("_MD_PDD_RESOURCEREPORTED", "Resource Reported Broken");
	define("_MD_PDD_RESOURCEREPORTED2", "This resource has been already reported as broken, we are working on a fix");
	define("_MD_PDD_BROWSETOTOPIC", "<b>Browse Downloads by alphabetical listing</b>");
	define("_MD_PDD_WEBMASTERACKNOW", "Broken Report Acknowledged: ");
	define("_MD_PDD_WEBMASTERCONFIRM", "Broken Report Confirmed: ");
	define("_MD_PDD_DELETE", "Delete");
	define("_MD_PDD_DISPLAYING", "Displayed by: ");
	define("_MD_PDD_LEGENDTEXTNEW", "New Today");
	define("_MD_PDD_LEGENDTEXTNEWTHREE", "New 3 Days");
	define("_MD_PDD_LEGENDTEXTTHISWEEK", "New This Week");
	define("_MD_PDD_LEGENDTEXTNEWLAST", "Over 1 Week");
	define("_MD_PDD_THISFILEDOESNOTEXIST", "Error: This file does not exist!");
	define("_MD_PDD_BROKENREPORTED", "Broken File Reported");
	define("_MD_PDD_SELCAT","You have to select a categorie!");
	// visit
	define("_MD_PDD_DOWNINPROGRESS", "Download in Progress");
	define("_MD_PDD_DOWNSTARTINSEC", "Your download should start in 5 seconds...<b>please wait</b>.");
	define("_MD_PDD_DOWNSTARTINSEC1", "Your download should start in 1 seconds...<b>please wait</b>.");
	define("_MD_PDD_DOWNNOTSTART", "If your download does not start, ");
	define("_MD_PDD_CLICKHERE", "Click here!");
	define("_MD_PDD_BROKENFILE", "Broken File");
	define("_MD_PDD_PLEASEREPORT", "Please report this broken file to the webmaster, ");
	define("_MD_PDD_KEYFEATURESC", "Key Features:<br /><br /><span style='font-weight: normal;'>Seperate each Key Feature with a <b>#</b></span>");
	define("_MD_PDD_HISTORYC", "Download History:");
	define("_MD_PDD_HISTORYD", "Add New Download History:<br /><br /><span style='font-weight: normal;'>The Submit date will automatically be added to this.</span>");
	define("_MD_PDD_HOMEPAGETITLEC", "Home Page Title: ");
	define("_MD_PDD_REQUIREMENTS", "System Requirements:");
	define("_MD_PDD_FEATURES", "Features:");
	define("_MD_PDD_HISTORY", "Download History:");
	define("_MD_PDD_SCREENSHOT", "Screenshot:");
	define("_MD_PDD_SCREENSHOTCLICK", "Display full image");
	define("_MD_PDD_OTHERBYUID", "Other files by: ");
	define("_MD_PDD_DOWNTIMES", "Download Times: ");
	define("_MD_PDD_MAINTOTAL", "Total Files: ");
	define("_MD_PDD_DOWNLOADNOW", "Download Now");
	define("_MD_PDD_PAGES", "<b>Pages</b>");
	define("_MD_PDD_SUBMITTER", "Submitter");
	define("_MD_PDD_ERROR", "Error Updating Database: Information not saved");
	define("_MD_PDD_COPYRIGHT", "copyright");
	define("_MD_PDD_INFORUM", "Discuss In Forum");

	//submit.php
	define("_MD_PDD_NOTALLOWESTOSUBMIT","You are not allowed to submit files");
	define("_MD_PDD_INFONOSAVEDB","Information not saved to database: <br /><br />");

	//
	define("_MD_PDD_NEWLAST","New Submitted Before Last Week");
	define("_MD_PDD_NEWTHIS","New Submitted Within This week");
	define("_MD_PDD_THREE","New Submitted Within Last Three days");
	define("_MD_PDD_TODAY","New Submitted Today");
	define("_MD_PDD_NO_FILES","No Files Yet");
	define("_AM_PDD_IMAGEEXIST", "Screenshot already exist!");
}
?>
