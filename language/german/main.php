<?php
/**
 * $Id: main.php v 1.22 02 july 2004 Liquid Exp $
 * Module: PD-Downloads
 * Version: v1.0
 * Release Date: 04. M�rz 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( '_MD_PDD_NODOWNLOAD' ) ) {

	define("_MD_PDD_NODOWNLOAD", "Der Download existiert nicht!");
	define("_MD_PDD_NOCAT", "Die Kategorie existiert nicht!");
	define("_MD_PDD_NOUSER", "Der Benutzer existiert nicht!");

	define("_MD_PDD_SUBCATLISTING", "Unterkategorie(n)");
	define("_MD_PDD_ISADMINNOTICE", "Webmaster: Mit diesem Bild gibt es ein Problem.");
	define("_MD_PDD_THANKSFORINFO", "Danke f&uuml;r die &Uuml;bermittlung. Du wirst informiert, sobald Deine Einsendung vom Webmaster freigegeben wurde.");
	define("_MD_PDD_ISAPPROVED", "Danke f&uuml;r die &Uuml;bermittlung. Deine Einsendung wurde &uuml;berpr&uuml;ft, freigegeben und wird ab jetzt gelistet.");
	define("_MD_PDD_THANKSFORHELP", "Vielen Dank f&uuml;r die Hilfe, diese Liste aktuell zu halten.");
	define("_MD_PDD_FORSECURITY", "Aus Sicherheitsgr&uuml;nden werden Username und IP-Adresse tempor&auml;r gespeichert.");
	define("_MD_PDD_NOPERMISETOLINK", "Diese Datei geh&ouml;rt nicht zu der Seite von der Du kommst <br /><br />Bitte nimm kontakt mit dem dortigen Webmaster auf und teile ihm mit, dass:   <br /><b>ER KEINE LINKS UNSERER SITE LEECHEN SOLL!!</b> <br /><br /><b>Definition eines Leechers:</b> Jemand der zu faul ist von seinem eigenen Server aus zu verlinken, oder einfach nur die Arbeit anderer als seine eigene ausgibt<br /><br />  Deine IP Adresse <b>wurde gespeichert</b>.");
	define("_MD_PDD_DESCRIPTION", "Beschreibung: ");
	define("_MD_PDD_SUBMITCATHEAD", "Formular: Melde Download");
	define("_MD_PDD_MAIN", "Index");
	define("_AM_PDD_MYTOTAL", "Gesamt");
	define("_MD_PDD_POPULAR", "Popul&auml;r");
	define("_MD_PDD_NEWTHISWEEK", "Neu diese Woche");
	define("_MD_PDD_UPTHISWEEK", "Aktualisiert diese Woche");
	define("_MD_PDD_POPULARITYLTOM", "Popularit&auml;t (geringste bis h&ouml;chste Anzahl Hits)");
	define("_MD_PDD_POPULARITYMTOL", "Popularit&auml;t (h&ouml;chste bis geringste Anzahl Hits)");
	define("_MD_PDD_TITLEATOZ", "Titel (A bis Z)");
	define("_MD_PDD_TITLEZTOA", "Titel (Z bis A)");
	define("_MD_PDD_DATEOLD", "Datum (&auml;ltere zuerst)");
	define("_MD_PDD_DATENEW", "Datum (neuere zuerst)");
	define("_MD_PDD_RATINGLTOH", "Bewertung (niedrigster bis h&ouml;chster Score)");
	define("_MD_PDD_RATINGHTOL", "Bewertung (h&ouml;chster bis niedrigster Score)");
	define("_MD_PDD_DESCRIPTIONC", "Beschreibung: ");
	define("_MD_PDD_CATEGORYC", "Kategorie: ");
	define("_MD_PDD_VERSION", "Version");
	define("_MD_PDD_SUBMITDATE", "Ver&ouml;ffentlicht");
	define("_MD_PDD_DLTIMES", "%s mal gedwonloadet");
	define("_MD_PDD_FILESIZE", "Dateigr&ouml;&szlig;e");
	define("_MD_PDD_SUPPORTEDPLAT", "Plattform");
	define("_MD_PDD_HOMEPAGE", "Homepage");
	define("_MD_PDD_PUBLISHERC", "Ver�ffentlicht von: ");
	define("_MD_PDD_RATINGC", "Bewertung: ");
	define("_MD_PDD_ONEVOTE", "1 Wertung");
	define("_MD_PDD_NUMVOTES", "%s Wertungen");
	define("_MD_PDD_RATETHISFILE", "Bewerten");
	define("_MD_PDD_DOWNLOADHITS", "Aufrufe: ");
	define("_MD_PDD_MODIFY", "Modifizieren");
	define("_MD_PDD_REPORTBROKEN", "Datei als defekt melden");
	define("_MD_PDD_BROKENREPORT", "Defekte Ressource melden");
	define("_MD_PDD_SUBMITBROKEN", "Einsenden");
	define("_MD_PDD_BEFORESUBMIT", "Bevor eine defekte Ressource gemeldet wird sollte bitte &uuml;berpr&uuml;ft werden, ob die gesuchte Ressource wirklich nicht mehr verf&uuml;gbar, oder die entsprechende Seite nur tempor&auml;r offline ist.");
	define("_MD_PDD_TELLAFRIEND", "Empfehlen");
	define("_MD_PDD_EDIT", "Editieren");
	define("_MD_PDD_THEREARE", "Es gibt <b>%s</b> <i>Kategorien</i> und <b>%s</b> <i>Downloads</i>");
	define("_MD_PDD_THEREIS", "Es gibt <b>%s</b> <i>Kategorie</i> und <b>%s</b> <i>Downloads</i>");
	define("_MD_PDD_LATESTLIST", "Aktuellste Downloads");
	define("_MD_PDD_FILETITLE", "Downloadtitle: ");
	define("_MD_PDD_DLURL", "Download-URL: ");
	define("_MD_PDD_HOMEPAGEC", "Homepage: ");
	define("_MD_PDD_UPLOAD_FILEC", "Datei hochladen:");
	define("_MD_PDD_UPLOAD_FILESIZE", "<br /><br />Erlaubte Dateigr��e: ");
	define("_MD_PDD_VERSIONC", "Version: ");
	define("_MD_PDD_FILESIZEC", "Dateigr&ouml;&szlig;e in KB: ");
	define("_AM_PDD_SHOTIMAGE", "Screenshot: ");
	define("_AM_PDD_UPLOADSHOTIMAGE", "Screenshot hochladen: ");
	define("_MD_PDD_NUMBYTES", "%s Bytes");
	define("_MD_PDD_PLATFORMC", "Plattform: ");
	define("_MD_PDD_NOTSPECIFIED", "Nicht angegeben");
	define("_MD_PDD_PUBLISHER", "Ver�ffentlicht von");
	define("_MD_PDD_UPDATEDON", "Aktualisiert am");
	define("_MD_PDD_VIEWDETAILS", "Alle Details anzeigen");
	define("_MD_PDD_OPTIONS", 'Optionen: ');
	define("_MD_PDD_NOTIFYAPPROVE", 'Benachrichtigen wenn diese Datei freigegeben wird');
	define("_MD_PDD_VOTEAPPRE", "Deine Bewertung ist willkommen.");
	define("_MD_PDD_THANKYOU", "Danke dass Du Dir die Zeit nimmst auf %s abzustimmen"); // %s is your site name
	define("_MD_PDD_VOTEONCE", "Bitte nicht mehrfach f&uuml;r die gleiche Ressource abstimmen.");
	define("_MD_PDD_RATINGSCALE", "Die Skala reicht von 1 - 10, wobei 1 sehr schlecht und 10 sehr gut ist.");
	define("_MD_PDD_BEOBJECTIVE", "Bitte sei objektiv. Wenn jeder nur mit 1 oder 10 abstimmt, ist die Bewertung nicht sehr hilfreich.");
	define("_MD_PDD_DONOTVOTE", "Bitte keine eigenen Ressourcen bewerten.");
	define("_MD_PDD_RATEIT", "Bewerten!");
	define("_MD_PDD_INTFILEFOUND", "Auf %s gibt es eine interessante Datei zum Download"); // %s is your site name
	define("_MD_PDD_RANK", "Rank");
	define("_MD_PDD_CATEGORY", "Kategorie");
	define("_MD_PDD_HITS", "Hits");
	define("_MD_PDD_RATING", "Bewertung");
	define("_MD_PDD_VOTE", "Wertungen");
	define("_MD_PDD_SORTBY", "Sortieren nach:");
	define("_MD_PDD_TITLE", "Titel");
	define("_MD_PDD_DATE", "Datum");
	define("_MD_PDD_POPULARITY", "Popularit&auml;t");
	define("_MD_PDD_TOPRATED", "Bewertung");
	define("_MD_PDD_CURSORTBY", "Dateien werden im Moment nach %s sortiert");
	define("_MD_PDD_CANCEL", "Abbrechen");
	define("_MD_PDD_ALREADYREPORTED", "Du hast diese Ressource bereits als defekt gemeldet.");
	define("_MD_PDD_MUSTREGFIRST", "Leider hast Du nicht die Berechtigung f&uuml;r diese Aktion.<br />Bitte zun&auml;chst registrieren oder anmelden!");
	define("_MD_PDD_NORATING", "Keine Bewertung ausgew&auml;hlt.");
	define("_MD_PDD_CANTVOTEOWN", "Du darfst f&uuml;r die Ressource die Du eingesendet hast nicht abstimmen.<br />Alle Stimmen werden geloggt und &uuml;berpr&uuml;ft.");
	define("_MD_PDD_SUBMITDOWNLOAD", "Download einsenden");
	define("_MD_PDD_SUB_SNEWMNAMEDESC", "<ul><li>Alle neuen Downloads werden zun&auml;chst verifiziert. Es kann daher bis zu 24 Stunden dauern, ehe sie in unserem Listing erscheinen.</li><li>Wir behalten uns das Recht vor, eingesendete Ressourcen abzulehnen oder ohne Nachfrage die Informationen zu modifizieren.</li></ul>");
	define("_MD_PDD_MAINLISTING", "Hauptindex");
	define("_MD_PDD_LASTWEEK", "Letzte Woche");
	define("_MD_PDD_LAST30DAYS", "Letzten 30 Tage");
	define("_MD_PDD_1WEEK", "1 Woche");
	define("_MD_PDD_2WEEKS", "2 Wochen");
	define("_MD_PDD_30DAYS", "30 Tage");
	define("_MD_PDD_SHOW", "Zeigen");
	define("_MD_PDD_DAYS", "Tage");
	define("_MD_PDD_NEWDOWNLOADS", "Neue Downloads");
	define("_MD_PDD_TOTALNEWDOWNLOADS", "Neue Downloads insgesamt");
	define("_MD_PDD_DTOTALFORLAST", "Neueste Downloads der letzten Zeit");
	define("_MD_PDD_AGREE", "Ich stimme zu");
	define("_MD_PDD_DOYOUAGREE", "Mit den Bestimmungen einverstanden?");
	define("_MD_PDD_DISCLAIMERAGREEMENT", "Bestimmungen (Disclaimer)");
	define("_MD_PDD_DUPLOADSCRSHOT", "Screenshot hochladen:");
	define("_MD_PDD_RESOURCEID", "Ressource id#: ");
	define("_MD_PDD_REPORTER", "Original Reporter: ");
	define("_MD_PDD_DATEREPORTED", "Gemeldet am: ");
	define("_MD_PDD_RESOURCEREPORTED", "Als defekt gemeldete Ressource");
	define("_MD_PDD_RESOURCEREPORTED2", "Die Ressource wurde bereits als defekt gemeldet und wird demn�chst gefixt");
	define("_MD_PDD_BROWSETOTOPIC", "<b>Downloads in alphabetischer Reihenfolge durchuchen</b>");
	define("_MD_PDD_WEBMASTERACKNOW", "Annerkannte Defektmeldungen: ");
	define("_MD_PDD_WEBMASTERCONFIRM", "Best&auml;tigte Defektmeldungen: ");
	define("_MD_PDD_DELETE", "L&ouml;schen");
	define("_MD_PDD_DISPLAYING", "Dargestellt: ");
	define("_MD_PDD_LEGENDTEXTNEW", "Heute neu");
	define("_MD_PDD_LEGENDTEXTNEWTHREE", "letzten 3 Tage");
	define("_MD_PDD_LEGENDTEXTTHISWEEK", "diese Wochen");
	define("_MD_PDD_LEGENDTEXTNEWLAST", "&auml;lter als 1 Woche");
	define("_MD_PDD_THISFILEDOESNOTEXIST", "Fehler: Die Datei existiert nicht!");
	define("_MD_PDD_BROKENREPORTED", "Datei als defekt gemeldet");
	define("_MD_PDD_SELCAT","Es muss eine Kategorie ausgew�hlt werden!");
	// visit
	define("_MD_PDD_DOWNINPROGRESS", "Download in Progress");
	define("_MD_PDD_DOWNSTARTINSEC", "Der Download sollte in 3 Sekunden beginnen...<b>bitte warten</b>.");
	define("_MD_PDD_DOWNSTARTINSEC1", "Der Download sollte in 1 Sekunden beginnen...<b>bitte warten</b>.");
	define("_MD_PDD_DOWNNOTSTART", "Sollte der angeforderte Download nicht beginnen, ");
	define("_MD_PDD_CLICKHERE", "Hier klicken!");
	define("_MD_PDD_BROKENFILE", "Defekte Datei");
	define("_MD_PDD_PLEASEREPORT", "Bitte melde dem Webmaster diese Datei als defekt, ");
	define("_MD_PDD_KEYFEATURESC", "Features:<br /><br /><span style='font-weight: normal;'>Jedes Feature mit <b>#</b> separieren</span>");
	define("_MD_PDD_HISTORYC", "Download History:");
	define("_MD_PDD_HISTORYD", "Neue History hinzuf&uuml;gen:<br /><br /><span style='font-weight: normal;'>Das Einsendedatum wird automatisch hinzugef&uuml;gt.</span>");
	define("_MD_PDD_HOMEPAGETITLEC", "Homepage Titel: ");
	define("_MD_PDD_REQUIREMENTS", "System Voraussetzung:");
	define("_MD_PDD_FEATURES", "Features:");
	define("_MD_PDD_HISTORY", "Download History:");
	define("_MD_PDD_SCREENSHOT", "Screenshot:");
	define("_MD_PDD_SCREENSHOTCLICK", "Vollbildanzeige");
	define("_MD_PDD_OTHERBYUID", "Andere Dateien von: ");
	define("_MD_PDD_DOWNTIMES", "Downloaddauer: ");
	define("_MD_PDD_MAINTOTAL", "Dateien gesamt: ");
	define("_MD_PDD_DOWNLOADNOW", "Jetzt Downloaden");
	define("_MD_PDD_PAGES", "Seiten");
	define("_MD_PDD_SUBMITTER", "Eingesendet von");
	define("_MD_PDD_ERROR", "Datenbankupdate-Fehler: Information konnte nicht gesichert werden");
	define("_MD_PDD_COPYRIGHT", "Copyright");
	define("_MD_PDD_INFORUM", "Im Forum diskutieren");

	//submit.php
	define("_MD_PDD_NOTALLOWESTOSUBMIT","Keine Berechtigung zum &Uuml;bertragen von Dateien");
	define("_MD_PDD_INFONOSAVEDB","Information wurde nicht in die Datenbank &uuml;bernommen: <br /><br />");

	//
	define("_MD_PDD_NEWLAST","Neu eingegangen vor der letzten Woche");
	define("_MD_PDD_NEWTHIS","Neu eingegangen diese Woche");
	define("_MD_PDD_THREE","Neu eingegenagen innerhalb der letzten drei Tage");
	define("_MD_PDD_TODAY","Heute neu eingegangen");
	define("_MD_PDD_NO_FILES","Noch keine Dateien");
	define("_AM_PDD_IMAGEEXIST", "Screenshot existiert bereits!");
}
?>