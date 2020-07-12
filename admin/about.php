<?php
/**
 * $Id: index.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */
 
include 'admin_header.php';

global $xoopsModule;

xoops_cp_header();

$file = '../versionhistory.txt';
if (@file_exists($file))
{
    $fp = @fopen($file, "r");
    $bugtext = @fread($fp, filesize($file));
    @fclose($file);
} 

$file1 = '../modulinfos.txt';
if (@file_exists($file1))
{
    $fp = @fopen($file1, "r");
    $infotext = @fread($fp, filesize($file1));
    @fclose($file1);
} 

$module_handler = & xoops_gethandler('module');
$versioninfo = & $module_handler -> get($xoopsModule -> getVar('mid'));

PDd_adminmenu();
// Left headings...
	echo "<img src='" . XOOPS_URL . "/modules/$mydirname/" . $versioninfo -> getInfo('image') . "' alt='' hspace='10' vspace='0' /></a>\n
		<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $versioninfo -> getInfo('name') . " version " . $versioninfo -> getInfo('version') . "</div>\n
		<div>\n";
if ($versioninfo -> getInfo('author_realname') != '')
{
    $author_name = $versioninfo -> getInfo('author') . " (" . $versioninfo -> getInfo('author_realname') . ")";
} 
else
{
    $author_name = $versioninfo -> getInfo('author');
} 
	echo '
		</div>
		<table width="100%"><tr><td align="left"><div>' . _MI_PDD_RELEASE . ' ' . $versioninfo -> getInfo("releasedate") . '</div><div>' . _AM_PDD_BY . ' ' . $author_name . '</div><div>' . $versioninfo -> getInfo("license") . '</div></td><td align="right"><b>When you like this Module, please feel free to donate.</b></td><td align="right"><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="image" src="https://www.paypal.com/de_DE/i/btn/x-click-but04.gif" border="0" name="submit" alt="Zahlen Sie mit PayPal - schnell, kostenlos und sicher!"><input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIG/QYJKoZIhvcNAQcEoIIG7jCCBuoCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYAff0uone6Da9JEoOS9lXxGTMRDyszl3+1UgFat7ulGV6guiUxzxmZPm2J1DBZiYtDywylZ1YNhqvZyCKLkABJY1QnCqkOZTLFbKRZqfIvATRhKqEyJBxXLO2s2FoEClKFJVrBBD7cmz7UKikoi9yGgNI1js9M02GYYdj/kS2qpeTELMAkGBSsOAwIaBQAwewYJKoZIhvcNAQcBMBQGCCqGSIb3DQMHBAh0sars9HPXooBYhzb/d4ne5hzkZbWUxPQ5hG5nCuKkRboDPGKWQTXzLWj+cSxApHrW8YY8Ne2x3fuyULC5xkcXCIfnlE7QXgj0dHsSONJ22hctqLHBJgcQnGcX7TS7l32TBKCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFj		AUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbG		l2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTA1MDIyMDAyNTc1NlowIwYJKoZIhvcNAQkEMRYEFAfTq6L+QkhTG2WSXV0C2mE9w1eGMA0GCSqGSIb3DQEBAQUABIGAC0j8sGOJCu4LVfb+p9K2YEATdTHOxuoRGdr2EmUlkP4c3cKGEIewNQYUXw+oNQwyvtuFB29mMH02QBfPoht7ICdDwlUFsLeFS5SoIf5WSJ4ahJ+wb7A3179/uiSbIrTyLEDNdQ1AtKSzS4lEXsEOer5qrbJGw5tUfl3S77jf93c=-----END PKCS7-----"></form></tr></table>';
				
// Author Information
$sform = new XoopsThemeForm(_MI_PDD_AUTHOR_INFO, "", "");

$sform -> addElement(new XoopsFormLabel(_MI_PDD_AUTHOR_NAME, $author_name));

$sform -> addElement(new XoopsFormLabel(_MI_PDD_AUTHOR_WEBSITE, "<a href='" . $versioninfo -> getInfo('author_website_url') . "' target='_blank'>" . $versioninfo -> getInfo('author_website_name') . "</a>"));

$sform -> addElement(new XoopsFormLabel(_MI_PDD_AUTHOR_EMAIL, "<a href='mailto:" . $versioninfo -> getInfo('author_email') . "'>" . $versioninfo -> getInfo('author_email') . "</a>"));

$sform -> display();
// Author Information
$sform = new XoopsThemeForm(_MI_PDD_MODULE_DEVINFO, "", "");

$sform -> addElement(new XoopsFormLabel(_MI_PDD_MODULE_STATUS, $versioninfo -> getInfo('status')));
$sform -> display();
//about this module
$sform = new XoopsThemeForm(_MI_PDD_MODULE_INFO, "", "");
ob_start();
echo "<div class='even'>".$myts->displayTarea($infotext)."</div>";
$sform -> addElement(new XoopsFormLabel('', ob_get_contents(), 0));
ob_end_clean();
$sform -> display();
unset($file1);

$sform = new XoopsThemeForm(_MI_PDD_MODULE_DISCLAIMER, "", "");
ob_start();
echo "<div class='even'>" . $versioninfo -> getInfo('warning') . "</div>";
$sform -> addElement(new XoopsFormLabel('', ob_get_contents(), 0));
ob_end_clean();
$sform -> display();

$sform = new XoopsThemeForm(_MI_PDD_AUTHOR_CREDITS, "", "");
ob_start();
echo "<div class='even'>" . $versioninfo -> getInfo('author_credits') . "</div>";
$sform -> addElement(new XoopsFormLabel('', ob_get_contents(), 0));
ob_end_clean();
$sform -> display();

$sform = new XoopsThemeForm(_MI_PDD_AUTHOR_BUGFIXES, "", "");
ob_start();
echo "<div class='even'>".$myts->displayTarea($bugtext)."</div>";
$sform -> addElement(new XoopsFormLabel('', ob_get_contents(), 0));
ob_end_clean();
$sform -> display();
unset($file);

xoops_cp_footer();

?>