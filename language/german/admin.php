<?php
/**
 * $Id: admin.php v 1.22 02 july 2004 Liquid Exp $
 * Module: PD-Downloads
 * Version: v1.0
 * Release Date: 04. M�rz 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( '_AM_PDD_BMODIFY' ) ) {

	define("_MD_PDD_NODOWNLOAD", "Der Download existiert nicht!");

	// Buttons
	define("_AM_PDD_BMODIFY", "&Auml;ndern");
	define("_AM_PDD_BDELETE", "L&ouml;schen");
	define("_AM_PDD_BADD", "Hinzuf&uuml;gen");
	define("_AM_PDD_BAPPROVE", "Freigeben");
	define("_AM_PDD_BIGNORE", "Ignorieren");
	define("_AM_PDD_BCANCEL", "Abbrechen");
	define("_AM_PDD_BSAVE", "Sichern");
	define("_AM_PDD_BRESET", "Zur&uuml;cksetzen");
	define("_AM_PDD_BMOVE", "Dateien verschieben");
	define("_AM_PDD_BUPLOAD", "Hochladen");
	define("_AM_PDD_BDELETEIMAGE", "Ausgew&auml;hltes Bild l&ouml;schen");
	define("_AM_PDD_BRETURN", "Zur&uuml;ck wo Du herkommst!");
	define("_AM_PDD_DBERROR", "Datenbank Zugriffs-Fehler: Bitte diesen Fehler einem der Webmaster der PD_Sections Homepage melden");
	//Banned Users
	define("_AM_PDD_NONBANNED", "Nicht gebannt");
	define("_AM_PDD_BANNED", "Gebannt");
	define("_AM_PDD_EDITBANNED", "Gebannte User editieren");
	// Other Options
	define("_AM_PDD_TEXTOPTIONS", "Texteinstellungen:");
	define("_AM_PDD_DISABLEHTML", " HTML Tags deaktivieren");
	define("_AM_PDD_DISABLESMILEY", " Smilie Icons deaktivieren");
	define("_AM_PDD_DISABLEXCODE", " XOOPS Code deaktivieren");
	define("_AM_PDD_DISABLEIMAGES", " Bilder deaktivieren");
	define("_AM_PDD_DISABLEBREAK", " XOOPS Zeilenumbruch verwenden?");
	define("_AM_PDD_UPLOADFILE", "Datei erfolgreich hochgeladen");
	define("_AM_PDD_NOMENUITEMS", "Keine Men&uuml;items innerhalb dieses Men&uuml;s");

	// Admin Bread crumb
	define("_AM_PDD_PREFS", "Einstellungen");
	define("_AM_PDD_PERMISSIONS", "Berechtigungen");
	define("_AM_PDD_BINDEX", "Hauptindex");
	define("_MI_PDD_BLOCKADMIN","Block Einstellungen");
	define("_AM_PDD_BLOCKADMIN", "Bl&ouml;cke");
	define("_AM_PDD_GOMODULE", "Gehe zu Modul");
	define("_AM_PDD_ABOUT", "�ber");
	define("_AM_PDD_UANDITOOL", "Upgrade and Import Tool");
	// Admin Summary
	define("_AM_PDD_SCATEGORY", "Kategorie: ");
	define("_AM_PDD_SFILES", "Dateien: ");
	define("_AM_PDD_SNEPDILESVAL", "Eingesendet: ");
	define("_AM_PDD_SMODREQUEST", "Modifiziert: ");
	// Admin Main Menu
	define("_AM_PDD_MCATEGORY", "Kategorien");
	define("_AM_PDD_MDOWNLOADS", "Downloads");
	define("_AM_PDD_INDEXPAGE", "Index Seitenverwaltung");
	define("_AM_PDD_MMIMETYPES", "Mimetypes");
	define("_AM_PDD_MVOTEDATA", "Bewertungen");
	define("_AM_PDD_MUPLOADS", "Bilder");
	define("_AM_PDD_STATISTIC", "Statistik");

	// Catgeory defines
	define("_AM_PDD_CCATEGORY_CREATENEW", "Kategorie anlegen");
	define("_AM_PDD_CCATEGORY_MODIFY", "Kategorie &auml;ndern");
	define("_AM_PDD_CCATEGORY_MOVE", "Dateien aus gew&auml;hlter Kategorie verschieben");
	define("_AM_PDD_CCATEGORY_MODIFY_TITLE", "Kategorietitel:");
	define("_AM_PDD_CCATEGORY_MODIFY_FAILED", "Verschieben fehlgeschlagen: Diese Kategorie kann nicht verschoben werden!");
	define("_AM_PDD_CCATEGORY_MODIFY_FAILEDT", "Verschieben fehlgeschlagen: Kategorie konnte nicht gefunden werden!");
	define("_AM_PDD_CCATEGORY_MODIFY_MOVED", "Dateien verschoben und Kategorie gel&ouml;scht");
	define("_AM_PDD_CCATEGORY_CREATED", "Neue Kategorie angelegt und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_CCATEGORY_MODIFIED", "Gew&auml;hlte Kategorie ge&auml;ndert und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_CCATEGORY_DELETED", "Gew&auml;hlte Kategorie gel&ouml;scht und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_CCATEGORY_AREUSURE", "WARNUNG: Soll die gew&auml;hlte Kategorie mit ALLEN Dateien und Kommentaren wirklich gel&ouml;scht werden?");
	define("_AM_PDD_CCATEGORY_NOEXISTS", "Es muss erst eine Kategorie erstellt werden, bevor Dateien in die Datenbank eingetragen werden k&ouml;nnen");
	define("_AM_PDD_FCATEGORY_GROUPPROMPT", "Kategorie Zugriffsberechtigungen:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Bitte Usergruppe ausw&auml;hlen, die zu Zugriff<br/>auf diese Kategorie haben soll.</span></div>");
	define("_AM_PDD_FCATEGORY_TITLE", "Titel f&uuml;r Kategorie:");
	define("_AM_PDD_FCATEGORY_WEIGHT", "Kategorie-Gewichtung: <div style='padding-top: 8px;'><span style='font-weight: normal;'>Reihenfolge in der die Kategorie auf der Indexseite erscheint<br/>(0=ganz oben)</span></div>");
	define("_AM_PDD_FCATEGORY_SUBCATEGORY", "Setze als Subkategorie von:");
	define("_AM_PDD_FCATEGORY_CIMAGE", "Kategoriebild ausw&auml;hlen:");
	define("_AM_PDD_FCATEGORY_DESCRIPTION", "Beschreibung f&uuml;r Kategorie erstellen:");
	/*
	* Index page Defines
	*/
	define("_AM_PDD_IPAGE_UPDATED", "Modul-Startseite ge&auml;ndert und Datenbank erfolgreich aktualisiert!");
	define("_AM_PDD_IPAGE_INFORMATION", "Indexseiten - Information");
	define("_AM_PDD_IPAGE_MODIFY", "&Auml;ndere Indexseite");
	define("_AM_PDD_IPAGE_CTITLE", "Titel Modulindexseite:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Dieser Subtitel erscheint unterhalb dem gew&auml;hlten Logo (falls dies ausgew&auml;hlt wird).</span></div>");
	define("_AM_PDD_IPAGE_CIMAGE", "Logo/Bild f&uuml;r Modulindex ausw&auml;hlen:");
	define("_AM_PDD_IPAGE_CHEADING", "Headerbereich (Indexseite):");
	define("_AM_PDD_IPAGE_CHEADINGA", "Header ausrichten (text-align):");
	define("_AM_PDD_IPAGE_CFOOTER", "Footerbereich (Indexseite):");
	define("_AM_PDD_IPAGE_CFOOTERA", "Footer ausrichten (text-align):");
	define("_AM_PDD_IPAGE_CLEFT", "Links");
	define("_AM_PDD_IPAGE_CCENTER", "Center");
	define("_AM_PDD_IPAGE_CRIGHT", "Rechts");
	/*
	*  Permissions defines
	*/
	define("_AM_PDD_PERM_MANAGEMENT", "Berechtigungs-Management");
	define("_AM_PDD_PERM_PERMSNOTE", "<div><b>Es gilt zu beachten</b>, da&szlig; obwohl die Berechtigungen hier korrekt gesetzt sein m&ouml;gen, eine Gruppe dennoch keine Sicht- und/oder Zugriffsrechte haben kann wenn entsprechende Modul-Rechte fehlen. Diese Rechte k&ouml;nnen unter <b>System > Gruppen</b> eingestellt werden. Dort die entsprechende Gruppe ausw&auml;hlen und die passenden Rechte setzen.</div>");
	define("_AM_PDD_PERM_CPERMISSIONS", "Kategorieberechtigungen");
	define("_AM_PDD_PERM_CSELECTPERMISSIONS", "Kategorie bestimmen die jeder Gruppe zug&auml;nglich ist");
	define("_AM_PDD_PERM_CNOCATEGORY", "Berechtigung kann nicht gesetzt werden: Es existieren noch keine Kategorien!");
	define("_AM_PDD_PERM_FPERMISSIONS", "Dateiberechtigung");
	define("_AM_PDD_PERM_FNOFILES", "Berechtigung kann nicht gesetzt werden: Es existieren noch keine Dateien!");
	define("_AM_PDD_PERM_FSELECTPERMISSIONS", "Datei bestimmen die jeder Gruppe zug&auml;nglich ist");
	/*
	* Upload defines
	*/
	define("_AM_PDD_DOWN_IMAGEUPLOAD", "Bild erfolgreich in entsprechenden Uploadbereich hochgeladen");
	define("_AM_PDD_DOWN_NOIMAGEEXIST", "Fehler: Es wurde keine Datei zum Upload ausgew&auml;hlt. Bitte Vorgang wiederholen!");
	define("_AM_PDD_DOWN_IMAGEEXIST", "Bild existiert bereits in diesem Uploadbereich!");
	define("_AM_PDD_DOWN_FILEDELETED", "Datei wurde gel&ouml;scht.");
	define("_AM_PDD_DOWN_FILEERRORDELETE", "Fehler beim L&ouml;schen der Datei: Datei existiert nicht auf dem Server.");
	define("_AM_PDD_DOWN_NOFILEERROR", "Fehler beim L&ouml;schen der Datei: Keine Datei zum L&ouml;schen ausgew&auml;hlt.");
	define("_AM_PDD_DOWN_DELETEFILE", "WARNUNG: Soll diese Bilddatei wirklich gel&ouml;scht werden?");
	define("_AM_PDD_DOWN_IMAGEINFO", "Server Status");
	define("_AM_PDD_DOWN_SPHPINI", "<b>Information aus der php.ini:</b>");
	define("_AM_PDD_DOWN_SAFEMODESTATUS", "Safe Mode Status: ");
	define("_AM_PDD_DOWN_REGISTERGLOBALS", "Register Globals: ");
	define("_AM_PDD_DOWN_SERVERUPLOADSTATUS", "Server Uploads Status: ");
	define("_AM_PDD_DOWN_MAXUPLOADSIZE", "Maximal erlaubte Uploadgr&ouml;&szlig;e: ");
	define("_AM_PDD_DOWN_MAXPOSTSIZE", "Maximal erlaubte POST-Gr&ouml;&szlig;e: ");
	define("_AM_PDD_DOWN_MAXEXECTIME", "Maximale Ausf�hrungszeit von Scripten:");
	define("_AM_PDD_DOWN_SAFEMODEPROBLEMS", " (Dadurch kann es zu Problemen kommen)");
	define("_AM_PDD_DOWN_GDLIBSTATUS", "GD Library Unterst&uuml;tzung: ");
	define("_AM_PDD_DOWN_GDLIBVERSION", "GD Library Version: ");
	define("_AM_PDD_DOWN_GDON", "<b>aktiviert</b> (Thumbnails k&ouml;nnen verwendet werden)");
	define("_AM_PDD_DOWN_GDOFF", "<b>deaktiviert</b> (keine Thumbnails m&ouml;glich)");
	define("_AM_PDD_DOWN_OFF", "<b>AUS</b>");
	define("_AM_PDD_DOWN_ON", "<b>AN</b>");
	define("_AM_PDD_DOWN_CATIMAGE", "Kategoriebilder");
	define("_AM_PDD_DOWN_SCREENSHOTS", "Screenshots");
	define("_AM_PDD_DOWN_MAINIMAGEDIR", "Hauptbilder");
	define("_AM_PDD_DOWN_FCATIMAGE", "Kategoriebilder Pfad");
	define("_AM_PDD_DOWN_FSCREENSHOTS", "Screenshots Pfad");
	define("_AM_PDD_DOWN_FMAINIMAGEDIR", "Hauptbild Pfad");
	define("_AM_PDD_DOWN_FUPLOADIMAGETO", "Bild hochladen: ");
	define("_AM_PDD_DOWN_FUPLOADPATH", "Uploadpfad: ");
	define("_AM_PDD_DOWN_FUPLOADURL", "Upload-URL: ");
	define("_AM_PDD_DOWN_FOLDERSELECTION", "Uploadziel ausw&auml;hlen:");
	define("_AM_PDD_DOWN_FSHOWSELECTEDIMAGE", "Zeige ausgew&auml;hltes Bild:");
	define("_AM_PDD_DOWN_FUPLOADIMAGE", "Neues Bild an die gew&auml;hlte Stelle hochladen:");

	// Main Index defines
	define("_AM_PDD_MINDEX_DOWNSUMMARY", "Zusammenfassung PD-Downloads");
	define("_AM_PDD_MINDEX_PUBLISHEDDOWN", "Ver&ouml;ffentlichte Dateien:");
	define("_AM_PDD_MINDEX_AUTOPUBLISHEDDOWN", "Dateien mit automatischem Ver&ouml;ffentlichungsdatum:");
	define("_AM_PDD_MINDEX_AUTOEXPIRE", "Dateien mit automatischem Ablaufdatum:");
	define("_AM_PDD_MINDEX_EXPIRED", "Dateien die abgelaufen sind:");
	define("_AM_PDD_MINDEX_OFFLINEDOWN", "Dateien mit Status -Offline-:");
	define("_AM_PDD_MINDEX_ID", "ID");
	define("_AM_PDD_MINDEX_TITLE", "Titel des Downloads");
	define("_AM_PDD_MINDEX_POSTER", "eingesandt von");
	define("_AM_PDD_MINDEX_SUBMITTED", "eingesendet am");
	define("_AM_PDD_MINDEX_ONLINESTATUS", "Onlinestatus");
	define("_AM_PDD_MINDEX_PUBLISHED", "Ver&ouml;ffentlicht");
	define("_AM_PDD_MINDEX_ACTION", "Aktion");
	define("_AM_PDD_MINDEX_NODOWNLOADSFOUND", "HINWEIS: Es existieren keine Dateien, die den Kriterien entsprechen");
	define("_AM_PDD_MINDEX_PAGE", "<b>Seite:<b> ");
	define('_AM_PDD_MINDEX_PAGEINFOTXT', '<ul><li>Einstellung der PD-Downloads-Startseite.</li><li>Das Logo, der Sectionsheader- und Footer , usw. k&ouml;nnen sehr einfach gewechselt werden um dem Look and Feel der gesamten Seite zu entsprechen</li></ul><br /><br />ANMERKUNG: Das hier selektierte Logo wird auf allen (PD-Downloads)Modulseiten erscheinen.');
	define("_AM_PDD_MINDEX_DOWNSEC","in unseren Downloadbereich");
	define("_MD_PDD_NUMBYTES", "%s bytes");
	define('_MD_PDD_AVAILABLE','Vorhanden');
	define('_MD_PDD_NOTAVAILABLE','<font color="red">Nicht Vorhanden</font>');
	define("_MD_PDD_CREATEMANUAL", "<b>ACHTUNG - Safe Mode ist ein</B>, der Pfad manuell erstellt werden.");
	define("_MD_PDD_CHMODMANUAL","<b>ACHTUNG - Safe Mode ist ein</B>, die Rechte m�ssen manuell eingestellt werden.");
	define('_MD_PDD_NOTWRITABLE','<font color="red">Nicht beschreibbar</font>');
	define('_MD_PDD_UPLOADPATH','%s werden in diesem Pfad gespeichert');
	define('_MD_PDD_UPLOADPATHINFO','Informationen �ber die Upload-Pfade');
	define('_MD_PDD_CREATETHEDIR','Erstellen');
	define('_MD_PDD_SETMPERM','Berechtigung setzen');
	define('_MD_PDD_DIRCREATED','Das Verzeichnis wurde erstellt');
	define('_MD_PDD_DIRNOTCREATED','Das Verzeichnis konnte nicht erstellt werden');
	define('_MD_PDD_PERMSET','Die Berechtigung wurde gesetzt');
	define('_MD_PDD_PERMNOTSET','Die Berechtigung konnte nicht gesetzt werden');
	define("_AM_PDD_UPLOADS","Uploads");

	// Submitted Files
	define("_AM_PDD_SUB_SUBMITTEDFILES", "&Uuml;bermittelte Dateien");
	define("_AM_PDD_SUB_FILESWAITINGINFO", "Wartende Dateien - Informationen");
	define("_AM_PDD_SUB_FILESWAITINGVALIDATION", "Dateien die auf Freigabe warten: ");
	define("_AM_PDD_SUB_APPROVEWAITINGFILE", "<b>Freigabe</b> - Gibt den neuen Download ohne &Uuml;berpr&uuml;fung frei.");
	define("_AM_PDD_SUB_EDITWAITINGFILE", "<b>Editiere</b> den neuen Download und gebe ihn anschlie&szlig;end frei.");
	define("_AM_PDD_SUB_DELETEWAITINGFILE", "<b>L&ouml;sche</b> den neuen Download.");
	define("_AM_PDD_SUB_NOFILESWAITING", "Es stimmen keine Dateien mit den vorliegenden Kriterien &uuml;berein");
	define("_AM_PDD_SUB_NEPDILECREATED", "Neue Datei erstellt und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_SUB_WANTTOAPPROVE", "Soll der Download, ohne vorherige Pr�fung, jetzt freigegeben werden?");
	// Mimetypes
	define("_AM_PDD_MIME_ID", "ID");
	define("_AM_PDD_MIME_EXT", "EXT");
	define("_AM_PDD_MIME_NAME", "Application Type");
	define("_AM_PDD_MIME_ADMIN", "Admin");
	define("_AM_PDD_MIME_USER", "User");
	// Mimetype Form
	define("_AM_PDD_MIME_CREATEF", "Mimetype erstellen");
	define("_AM_PDD_MIME_MODIFYF", "Mimetype modifizieren");
	define("_AM_PDD_MIME_EXTF", "Dateiendung (Extension):");
	define("_AM_PDD_MIME_NAMEF", "Application Type/Name:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Anwendung eintragen, die mit dieser Endung verkn&uuml;pft werden soll.</span></div>");
	define("_AM_PDD_MIME_TYPEF", "Mimetypes:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Jeden Mimetype eingeben, der mit der Endung verkn&uuml;pft sein soll. Mimetypes durch Leerzeichen trennen.</span></div>");
	define("_AM_PDD_MIME_ADMINF", "Erlaubte Admin Mimetypes");
	define("_AM_PDD_MIME_ADMINFINFO", "<b>Mimetypes die f&uuml;r Admins-Uploads erlaubt sind:</b>");
	define("_AM_PDD_MIME_USERF", "Erlaubte User Mimetypes");
	define("_AM_PDD_MIME_USERFINFO", "<b>Mimetypes die f&uuml;r User-Uploads erlaubt sind:</b>");
	define("_AM_PDD_MIME_NOMIMEINFO", "Kein Mimetype ausgew&auml;hlt.");
	define("_AM_PDD_MIME_FINDMIMETYPE", "Neuen Mimetype finden:");
	define("_AM_PDD_MIME_EXTFIND", "Suche Dateiendung:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Dateiendung eingeben, nach der gesucht werden soll.</span></div>");
	define("_AM_PDD_MIME_INFOTEXT", "<ul><li>Neue Mimetypes k&ouml;nnen mit dieser Form erstellt, editiert oder gel&ouml;scht werden.</li>
	<li>Suche nach einem neuen Mimetype &uuml;ber eine externe Website.</li>
	<li>Dargestellte Mimetypes f&uuml;r Admin- und User-Uploads anzeigen.</li>
	<li>&Auml;ndere Mimetype Uploadstatus.</li></ul>
	");

	// Mimetype Buttons
	define("_AM_PDD_MIME_CREATE", "Erstellen");
	define("_AM_PDD_MIME_CLEAR", "Zur&uuml;cksetzen");
	define("_AM_PDD_MIME_CANCEL", "Abbrechen");
	define("_AM_PDD_MIME_MODIFY", "&Auml;ndern");
	define("_AM_PDD_MIME_DELETE", "L&ouml;schen");
	define("_AM_PDD_MIME_FINDIT", "Get Extension!");
	// Mimetype Database
	define("_AM_PDD_MIME_DELETETHIS", "Delete Selected Mimetype?");
	define("_AM_PDD_MIME_MIMEDELETED", "Mimetype %s has been deleted");
	define("_AM_PDD_MIME_CREATED", "Mimetype Information Created");
	define("_AM_PDD_MIME_MODIFIED", "Mimetype Information Modified");
	// Vote Information
	define("_AM_PDD_VOTE_RATINGINFOMATION", "Bewertungs-Information");
	define("_AM_PDD_VOTE_TOTALVOTES", "Stimmen insgesamt: ");
	define("_AM_PDD_VOTE_REGUSERVOTES", "Stimmen registrierter User: %s");
	define("_AM_PDD_VOTE_ANONUSERVOTES", "Stimmen anonymer User: %s");
	define("_AM_PDD_VOTE_USER", "User");
	define("_AM_PDD_VOTE_IP", "IP Adresse");
	define("_AM_PDD_VOTE_USERAVG", "Durchschnitt aller Bewertungen");
	define("_AM_PDD_VOTE_TOTALRATE", "Abgegebene Stimmen");
	define("_AM_PDD_VOTE_DATE", "eingesendet am");
	define("_AM_PDD_VOTE_RATING", "Bewertung");
	define("_AM_PDD_VOTE_NOREGVOTES", "Keine Bewertung durch registrierte User");
	define("_AM_PDD_VOTE_NOUNREGVOTES", "Keine Bewertung durch anonyme User");
	define("_AM_PDD_VOTE_VOTEDELETED", "Bewertung gel&ouml;scht.");
	define("_AM_PDD_VOTE_ID", "ID");
	define("_AM_PDD_VOTE_FILETITLE", "Datei-Titel");
	define("_AM_PDD_VOTE_DISPLAYVOTES", "Bewertungen/ Abstimmungsergebnisse");
	define("_AM_PDD_VOTE_NOVOTES", "Keine User Bewertungen vorhanden");
	define("_AM_PDD_VOTE_DELETE", "Keine User Bewertungen vorhanden");
	define("_AM_PDD_VOTE_DELETEDSC", "<b>L&ouml;scht</b> die entsprechende Bewertung aus der Datenbank.");
	define("_AM_PDD_VOTEDELETED", "Die Bewertung wurde erfolgreich gel�scht.");

	// Modifications
	define("_AM_PDD_MOD_TOTMODREQUESTS", "&Auml;nderungsanfragen insgesamt: ");
	define("_AM_PDD_MOD_MODREQUESTS", "Ge&auml;nderte Dateien");
	define("_AM_PDD_MOD_MODREQUESTSINFO", "Informationen: Ge&auml;nderte Dateien");
	define("_AM_PDD_MOD_MODID", "ID");
	define("_AM_PDD_MOD_MODTITLE", "Titel");
	define("_AM_PDD_MOD_MODPOSTER", "Original von: ");
	define("_AM_PDD_MOD_DATE", "&uuml;bermittelt von");
	define("_AM_PDD_MOD_NOMODREQUEST", "Es existieren keine Anfragen, die den Kriterien entsprechen");
	define("_AM_PDD_MOD_TITLE", "Download Titel: ");
	define("_AM_PDD_MOD_LID", "Download ID: ");
	define("_AM_PDD_MOD_CID", "Kategorie: ");
	define("_AM_PDD_MOD_URL", "Download URL: ");
	define("_AM_PDD_MOD_SIZE", "Download Gr&ouml;&szlig;e: ");
	define("_AM_PDD_MOD_PUBLISHER", "ver&ouml;ffentlicht von: ");
	define("_AM_PDD_MOD_FEATURES", "Features: ");
	define("_AM_PDD_MOD_FORUMID", "Forum: ");
	define("_AM_PDD_MOD_DHISTORY", "Download History: ");
	define("_AM_PDD_MOD_SCREENSHOT", "Screenshot: ");
	define("_AM_PDD_MOD_HOMEPAGE", "Homepage: ");
	define("_AM_PDD_MOD_HOMEPAGETITLE", "Homepage Titel: ");
	define("_AM_PDD_MOD_VERSION", "Version: ");
	define("_AM_PDD_MOD_SHOTIMAGE", "Screenshot Bild: ");
	define("_AM_PDD_MOD_FILESIZE", "Dateigr&ouml;&szlig;e: ");
	define("_AM_PDD_MOD_PLATFORM", "Software-Plattform: ");
	define("_AM_PDD_MOD_DESCRIPTION", "Beschreibung: ");
	define("_AM_PDD_MOD_REQUIREMENTS", "Voraussetzungen: ");
	define("_AM_PDD_MOD_MODIFYSUBMITTER", "Eingesandt von: ");
	define("_AM_PDD_MOD_MODIFYSUBMIT", "Eingesandt von");
	define("_AM_PDD_MOD_PROPOSED", "Vorgeschlagene Downloaddetails");
	define("_AM_PDD_MOD_ORIGINAL", "Orginal Downloaddetails");
	define("_AM_PDD_MOD_REQDELETED", "&Auml;nderungsanfrage aus Datenbank entfernt");
	define("_AM_PDD_MOD_REQUPDATED", "Gew&auml;hlter Download erfolgreich modifiziert und Datenbank aktualisiert");
	define('_AM_PDD_MOD_VIEW','Zeigen');

	//File management
	define("_AM_PDD_FILE_ID", "Datei ID: ");
	define("_AM_PDD_FILE_IP", "Uploaders IP Adresse: ");
	define("_AM_PDD_FILE_ALLOWEDAMIME", "<div style='padding-top: 4px; padding-bottom: 4px;'><b>Erlaubte Admin Dateiendungen</b>:</div>");
	define("_AM_PDD_FILE_MODIFYFILE", "Dateiinformationen modifizieren");
	define("_AM_PDD_FILE_CREATENEPDILE", "Neuen Download erstellen");
	define("_AM_PDD_FILE_TITLE", "Downloadtitel: ");
	define("_AM_PDD_FILE_DLURL", "Download-URL (direkter URL): ");
	define("_AM_PDD_FILE_MIRRORURL", "Download-Mirror: ");
	define("_AM_PDD_FILE_DESCRIPTION", "Beschreibung des Downloads: ");
	define("_AM_PDD_FILE_DUPLOAD", " Datei hochladen:");
	define("_AM_PDD_FILE_DUPLOADSIZE", "<br /><br />Erlaubte Dateigr��e: ");
	define("_AM_PDD_FILE_CATEGORY", "Kategorie ausw&auml;hlen: ");
	define("_AM_PDD_FILE_HOMEPAGETITLE", "Homepage Titel: ");
	define("_AM_PDD_FILE_HOMEPAGE", "Homepage-URL: ");
	define("_AM_PDD_FILE_SIZE", "Dateigr&ouml;&szlig;e in KB: ");
	define("_AM_PDD_FILE_VERSION", "Dateiversion: ");
	define("_AM_PDD_FILE_PUBLISHER", "Ver&ouml;ffentlicht von: ");
	define("_AM_PDD_FILE_PLATFORM", "Software Plattform: ");
	define("_AM_PDD_FILE_KEYFEATURES", "Features:<br /><br /><span style='font-weight: normal;'>Jedes Feature durch <b>#</b> trennen</span>");
	define("_AM_PDD_FILE_DELEDITMESS", "Defektmeldung l�schen?<br /><br /><span style='font-weight: normal;'>Wenn Sie <b>JA</b> ausw�hlen wird die Defektmeldung automatisch gel�scht und Sie best�tigen damit auch das der Download jetzt wieder funktioniert.</span>");
	define("_AM_PDD_FILE_HISTORY", "Download History bearbeiten:<br /><br /><span style='font-weight: normal;'>In diesem Bereich sollten nur bestehende History-Informationen bearbeitet, oder neue aufgenommen werden.</span>");
	define("_AM_PDD_FILE_HISTORYD", "Neue Download History hinzuf&uuml;gen:<br /><br /><span style='font-weight: normal;'>Versionsnummer und Datum werden automatisch hinzugef&uuml;gt</span>");
	define("_AM_PDD_FILE_HISTORYVERS", "<b>Version: </b>");
	define("_AM_PDD_FILE_HISTORDATE", " <b>Aktualisiert:</b> ");
	define("_AM_PDD_FILE_FILESSTATUS", " Download offline setzen?<br /><br /><span style='font-weight: normal;'>Dadurch wird der Download nach Au&szlig;en unsichtbar f&uuml;r die Besucher.</span>");
	define("_AM_PDD_FILE_SETASUPDATED", " Download Status auf Aktualisiert (Updated) setzen?<br /><br /><span style='font-weight: normal;'>Dadurch wird das Updated Icon gesetzt.</span>");
	define("_AM_PDD_FILE_RESETCALLS", "Downloadz�hler zur�cksetzen?");
	define("_AM_PDD_FILE_SHOTIMAGE", "Screenshot ausw&auml;hlen: ");
	define("_AM_PDD_FILE_DISCUSSINFORUM", "Diskussion in Forum hinzuf&uuml;gen? (Nur Xoopsboard)");
	define("_AM_PDD_FILE_PUBLISHDATE", "Ver&ouml;ffentlichungsdatum:");
	define("_AM_PDD_FILE_EXPIREDATE", "Ablaufdatum:");
	define("_AM_PDD_FILE_CLEARPUBLISHDATE", "<br /><br />Ver&ouml;ffentlichungsdatum entfernen:");
	define("_AM_PDD_FILE_CLEAREXPIREDATE", "<br /><br />Ablaufdatum entfernen:");
	define("_AM_PDD_FILE_PUBLISHDATESET", " Ver&ouml;ffentlichungsdatum setzen auf: ");
	define("_AM_PDD_FILE_SETDATETIMEPUBLISH", " Setze Datum/Uhrzeit der Ver&ouml;ffentlichung");
	define("_AM_PDD_FILE_SETDATETIMEEXPIRE", " Setze Datum/Uhrzeit des Ablaufs");
	define("_AM_PDD_FILE_SETPUBLISHDATE", "<b>Setze Ver&ouml;ffentlichungsdatum: </b>");
	define("_AM_PDD_FILE_SETNEWPUBLISHDATE", "<b>Setze Ver&ouml;ffentlichungsdatum</b><br />");
	define("_AM_PDD_FILE_SETPUBDATESETS", "<b>Ver&ouml;ffentlichungsdatum gesetzt auf: </b><br />");
	define("_AM_PDD_FILE_EXPIREDATESET", " Ablaufdatum gesetzt auf: ");
	define("_AM_PDD_FILE_SETEXPIREDATE", "<b>Setze Ablaufdatum</b>");
	define("_AM_PDD_FILE_MUSTBEVALID", "G&uuml;ltige Screenshots m&uuml;ssen sich im Verzeichnis %s befinden (z.B. shot.gif). Leer lassen falls kein Bild existiert.");
	define("_AM_PDD_FILE_EDITAPPROVE", "Download freigeben:");
	define("_AM_PDD_FILE_NEPDILEUPLOAD", "Neue Downloaddatei eingetragen und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_FILE_FILEMODIFIEDUPDATE", "Ausgew�hlte Datei wurde modifiziert und die Datenbank wurde erfolgreich upgedatet");
	define("_AM_PDD_FILE_REALLYDELETEDTHIS", "Soll der Download wirklich gel&ouml;scht werden?");
	define("_AM_PDD_FILE_FILEWASDELETED", "Downloaddatei %s erfolgreich aus Datenbank entfernt!");
	define("_AM_PDD_FILE_USE_UPLOAD_TITLE", " Nutze Dateinamen als Dateititel.");
	define("_AM_PDD_FILE_FILEAPPROVED", "Datei freigegeben und Datenbank erfolgreich aktualisiert");
	define("_AM_PDD_FILE_CREATENEWSSTORY", "<b>News Story aus Download erstellen</b>");
	define("_AM_PDD_FILE_SUBMITNEWS", "Neue Datei als Artikel &uuml;bermitteln?");
	define("_AM_PDD_FILE_NEWSCATEGORY", "Nachrichten-/Artikelkategorie ausw&auml;hlen:");
	define("_AM_PDD_FILE_NEWSTITLE", "Nachrichtentitel:<div style='padding-top: 4px; padding-bottom: 4px;'><span style='font-weight: normal;'>Leer lassen um Downloaddatei als Artikeltitel zu verwenden</span></div>");
	define('_AM_PDD_ONETHING', 'Es kann nur in einem Newsmodul aufeinmal eine News ver�ffentlicht werden!');
	define("_AM_PDD_FILE_SELCAT","Es muss eine Kategorie ausgew�hlt werden!");
	define("_AM_PDD_FILE_GROUPPROMPT", "Download Zugriffsberechtigungen:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Bitte Usergruppe ausw&auml;hlen, die Zugriff<br/>auf diesen Download haben soll.</span></div>");

	/*
	* Broken downloads defines
	*/
	define("_AM_PDD_SBROKENSUBMIT", "Defekt: ");
	define("_AM_PDD_BROKEN_FILE", "Als defekt gemelde Downloads");
	define("_AM_PDD_BROKEN_FILEIGNORED", "Die Defektmeldung ignoriert und erfolgreich aus der Datenbank entfernt!");
	define("_AM_PDD_BROKEN_NOWACK", "Status *anerkannt* ge&auml;ndert und Datenbank aktualisiert!");
	define("_AM_PDD_BROKEN_NOWCON", "Status wurde auf *in Bearbeitung* ge&auml;ndert, Sie werden nun zur Download-Bearbeitung weitergeleitet.");
	define("_AM_PDD_BROKEN_REPORTINFO", "Defektmeldungen - Information");
	define("_AM_PDD_BROKEN_REPORTSNO", "Wartende Defektmeldungen:");
	define("_AM_PDD_BROKEN_IGNOREDESC", "<b>Ignoriere</b> und l�sche die Defektmeldung");
	define("_AM_PDD_BROKEN_DELETEDESC", "<b>L&ouml;sche</b> den gemeldeten Download und die Defektmeldung.");
	define("_AM_PDD_BROKEN_EDITDESC", "<b>Editiere</b> den Download um das Problem zu beheben.");
	define("_AM_PDD_BROKEN_ACKDESC", "<b>In Bearbeitung</b> - Dieser Download wurde bereits Bearbeitet aber noch nicht als funktionierend deklariert.");
	define("_AM_PDD_BROKEN_CONFIRMDESC", "<b>Best&auml;tigt</b> - Setzt den Status der Defektmeldung auf *best&auml;tigt*.");

	define("_AM_PDD_BROKEN_ID", "ID");
	define("_AM_PDD_BROKEN_TITLE", "Titel");
	define("_AM_PDD_BROKEN_REPORTER", "Reporter");
	define("_AM_PDD_BROKEN_FILESUBMITTER", "Eingesandt durch");
	define("_AM_PDD_BROKEN_DATESUBMITTED", "&Uuml;bermittelt am");
	define("_AM_PDD_BROKEN_ACTION", "Aktion");
	define("_AM_PDD_BROKEN_NOFILEMATCH", "Es exisitieren keine Defektmeldungen mit den gew&auml;hlten Kriterien");
	define("_AM_PDD_BROKENFILEDELETED", "Downloadbeschreibung und Defektmeldung aus Datenbank entfernt");

	/*
	* About defines
	*/
	define("_AM_PDD_BY", "von");

	/*
	* Upgrade and Import Tool defines
	*/
	define("_UI_PDD_INFO", "Information");
	define('_UI_PDD_INFOTEXT', '<b><u>UPGRADE:</u></b> <ul><li>Die Daten des ausgew�hlten Modules werden in dieses Modul importiert.</li>
<li>Das ausgew�hlte Module wird danach automatisch deaktiviert und deinstalliert.</li><li>Das ausgew�hlte Module muss dann nur noch vom Server gel�scht werden.</li></ul><br>
<b><u>IMPORT:</u></b><ul><li>Die Daten des ausgew�hlten Modules werden in dieses Modul importiert.</li><li>Das ausgew�hlte Module bleibt unangetastet und kann weiter verwendet werden.</li></ul><br>
<b>Es wird empfohlen die Upgrade-Funktion nur dann zu nutzen wenn man sich 100%ig sicher ist!</b>');
	define("_UI_PDD_SELMODULE","Modul-Auswahl");
	define("_UI_PDD_CHOOSEMODULE","Module auw�hlen:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Hier wird das Module ausgew�hlt von dem man Upgraden oder Daten importieren m�chte.</span></div>");
	define("_UI_PDD_ACTUALMODUL", "Daten werden in dieses Modul �bernommen:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Daten werden von dem oben ausgew�hlten Module in dieses Modul �bernommen.</span></div>");
	define("_UI_PDD_UPGRADE", "Upgraden");
	define("_UI_PDD_IMPORT", "Importieren");
	define("_UI_PDD_SUREUPGADE", "ACHTUNG: Soll das UPGRADE wirklich durchgef�hrt werden? <br>Dadurch wird das ausgew�hlte Module deinstalliert und alle bisher gespeicherten Daten des ausgew�hlte Modules werden vernichtet.");
	define("_UI_PDD_SUREIMPORT", "ACHTUNG: Alle bisher gespeicherten Daten dieses Modules werden gel�scht.");
	define("_UI_PDD_PART", "Schritt wird durchgef�hrt ...");
	define("_UI_PDD_OPTIONS", "Zus�tzliche Optionen:");
	define("_UI_PDD_WANTCOM", "Kommentare �bernehmen");
	define("_UI_PDD_WANTNOT", "Benachrichtigungseinstellungen �bernehmen");
	define("_UI_PDD_WANTPERM", "Berechtigungen �bernehmen<br><small>(Funktioniert nur mit WF- oder PD-Downloads)</small>");

	//block defines
	define("_AM_PDD_BADMIN","Block Administration");
	define("_AM_PDD_BLKDESC","Beschreibung");
	define("_AM_PDD_TITLE","Titel");
	define("_AM_PDD_SIDE","Ausrichtung");
	define("_AM_PDD_WEIGHT","Gewichtung");
	define("_AM_PDD_VISIBLE","Sichtbarkeit");
	define("_AM_PDD_ACTION","Aktion");
	define("_AM_PDD_SBLEFT","Links");
	define("_AM_PDD_SBRIGHT","Rechts");
	define("_AM_PDD_CBLEFT","Mitte - Links");
	define("_AM_PDD_CBRIGHT","Mitte - Rechts");
	define("_AM_PDD_CBCENTER","Mitte - Mitte");
	define("_AM_PDD_ACTIVERIGHTS","Aktive Berechtigungen");
	define("_AM_PDD_ACCESSRIGHTS","Zugriffs Berechtigungen");

	//image admin icon
	define("_AM_PDD_ICO_EDIT","Objekt editieren");
	define("_AM_PDD_ICO_DELETE","Objekt l&ouml;schen");
	define("_AM_PDD_ICO_ONLINE","Online");
	define("_AM_PDD_ICO_OFFLINE","Offline");
	define("_AM_PDD_ICO_APPROVED","Best&auml;tigt");
	define("_AM_PDD_ICO_NOTAPPROVED","Nicht best&auml;tigen");

	define("_AM_PDD_ICO_LINK","Verwandte Links");
	define("_AM_PDD_ICO_URL","Verwandten URL hinzuf&uuml;gen");
	define("_AM_PDD_ICO_ADD","Hinzuf&uuml;gen");
	define("_AM_PDD_ICO_APPROVE","Best&auml;tigung");
	define("_AM_PDD_ICO_STATS","Statistiken");

	define("_AM_PDD_ICO_IGNORE","Ignorieren");
	define("_AM_PDD_ICO_ACK","Anerkannte Defektmeldungen");
	define("_AM_PDD_ICO_REPORT","Defektmeldung anerkennen?");
	define("_AM_PDD_ICO_CONFIRM","Defektmeldung best&auml;tigt");
	define("_AM_PDD_ICO_CONBROKEN","Defektmeldung best&auml;tigen?");

	/*
	* Statistic defines
	*/
	define("_AM_PDD_VIEW","Aufrufe");
	define("_AM_PDD_ENTRIES", "Eintr�ge");
	define("_AM_PDD_EXPIRED", "Abgelaufene Eintr�ge");
	define("_AM_PDD_USENDFROM", "Einzigartige Einsender");
	define("_AM_PDD_TOTAL", "Insgesamt");
	define("_AM_PDD_DLSTAT", "Downloadstatistik");
	define("_AM_PDD_DLSTAT1", "Am h�uftigsten aufgerufene Downloads");
	define("_AM_PDD_DLSTAT2", "Am wenigsten aufgerufene Downloads");
	define("_AM_PDD_DLSTAT3", "Am besten bewertete Downloads");
	define("_AM_PDD_CREATERSTAT", "Erstellerstatistik");
	define("_AM_PDD_CREATERSTAT1", "Am h�ufigsten aufgerufene Ersteller");
	define("_AM_PDD_CREATERSTAT2", "Am besten bewertete Ersteller");
	define("_AM_PDD_CREATERSTAT3", "Haben am meisten erstellt");
	define("_AM_PDD_CREATERSTAT4", "Anzahl der Eintr�ge");
}
?>
