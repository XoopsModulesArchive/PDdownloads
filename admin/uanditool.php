<?php
/**
 * $Id: uanditool.php
 * Module: PD-Downloads
 * Version: v1.2
 * Release Date: 21. Dec 2005
 * Author: Power-Dreams Team
 * Licence: GNU
 */

include 'admin_header.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

xoops_cp_header();
PDd_adminmenu(8);

function upgrade()
{
	if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
	redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());

	$ok = (isset($_POST['ok']) && $_POST['ok'] == 1) ? intval($_POST['ok']) : 0;
	$selmodule = (isset($_POST['selmodule']) && $_POST['selmodule']) ? intval($_POST['selmodule']) : 0;
	$com = (isset($_POST['com']) && $_POST['com']) ? intval($_POST['com']) : 0;
	$perm = (isset($_POST['perm']) && $_POST['perm']) ? intval($_POST['perm']) : 0;
	$not = (isset($_POST['not']) && $_POST['not']) ? intval($_POST['not']) : 0;

	if (!isset($mydirname))
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

	if ($ok != 1)
	xoops_confirm(array('op' => 'upgrade', 'selmodule' => $selmodule, 'ok' => 1, 'perm' => $perm, 'com' => $com, 'not' => $not), 'uanditool.php', _UI_PDD_SUREUPGADE, '' , true);
	else
	{
		$importok = import(1,1);
		if (isset($importok) && $importok == 1)
		{
			global $xoopsDB, $xoopsUser, $xoopsModule;
			$modulefolder = findmodules(1, $mydirname);
			$modulename = findmodules(0, $mydirname);
			$id = getInfosfromModule($modulefolder[$selmodule], "mid");
			echo "<br><b><u>6. "._UI_PDD_PART."</u></b><br>";
			include_once XOOPS_ROOT_PATH.'/class/xoopsblock.php';
			include_once XOOPS_ROOT_PATH."/modules/system/admin/modulesadmin/modulesadmin.php";
			error_reporting(0);
			xoops_module_deactivate($id);
			if ($xoopsDB->getRowsNum($xoopsDB->queryF("SELECT * FROM " . $xoopsDB -> prefix("modules") . " WHERE dirname = '$modulefolder[$selmodule]' AND isactive = 0")) > 0)
			echo "<b>Success:</b> Module <b>$modulename[$selmodule]</b> was <span style='color:#FF0000;font-weight:bold'>deactivated</span> successfully.<br>";
			else
			{
				echo "<b>Error:</b> Module <b>$modulename[$selmodule]</b> could <span style='color:#FF0000;font-weight:bold'>not be deactivated</span><br>";
				return;
			}
			xoops_module_uninstall($modulefolder[$selmodule]);
			error_reporting(E_ALL);
			if ($xoopsDB->getRowsNum($xoopsDB->queryF("SELECT * FROM " . $xoopsDB -> prefix("modules") . " WHERE dirname = '$modulefolder[$selmodule]' AND isactive = 0")) == 0)
			echo "<b>Success:</b> Module <b>$modulename[$selmodule]</b> was <span style='color:#FF0000;font-weight:bold'>deinstalled</span> successfully.<br>";
			else
			{
				echo "<b>Error:</b> Module <b>$modulename[$selmodule]</b> could <span style='color:#FF0000;font-weight:bold'>not be deinstalled</span><br>";
				return;
			}
			echo "<br><h3><span style='color:#ff0000;font-weight:bold'>Upgrading successfully finished.</span></h3>";
		}
	}
}

function import($upgrade=0, $ok='')
{
	global $xoopsDB;

	if (empty($ok))
	{
		$ok = (isset($_POST['ok']) && $_POST['ok'] == 1) ? intval($_POST['ok']) : 0;
		if (is_object($GLOBALS['xoopsSecurity']) and !$GLOBALS['xoopsSecurity']->check())
		redirect_header(XOOPS_URL.'/',3,$GLOBALS['xoopsSecurity']->getErrors());
	}
	$selmodule = (isset($_POST['selmodule']) && $_POST['selmodule']) ? intval($_POST['selmodule']) : 0;
	$com = (isset($_POST['com']) && $_POST['com']) ? intval($_POST['com']) : 0;
	$perm = (isset($_POST['perm']) && $_POST['perm']) ? intval($_POST['perm']) : 0;
	$not = (isset($_POST['not']) && $_POST['not']) ? intval($_POST['not']) : 0;

	if (!isset($mydirname))
	$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;

	if ($ok != 1)
	xoops_confirm(array('op' => 'import', 'selmodule' => $selmodule, 'ok' => 1, 'perm' => $perm, 'com' => $com, 'not' => $not), 'uanditool.php', _UI_PDD_SUREIMPORT, '' , true);
	else
	{
		/*
		first we get all tables from the actually module
		then we check if the tables exist and after that the tables will be deleted
		*/
		$modulefolder = findmodules(1, $mydirname);
		$mytables = getTables($mydirname);
		$oldtables = getTables($modulefolder[$selmodule]);
		$oldtablesuffix = makesuffix($oldtables);
		$mytablesuffix = makesuffix($mytables);
		$myname = makemodulename($mytables);
		$oldname = makemodulename($oldtables);
		$myfields = getFields($mytables, $mytablesuffix);
		$myfieldsindexes = getFieldsIndexes($mytables, $mytablesuffix);
		$oldfields = getFields($oldtables, $oldtablesuffix);
		$oldfieldsindexes = getFieldsIndexes($oldtables, $oldtablesuffix);
		$del = array_diff($oldtablesuffix, $mytablesuffix);
		$add = array_diff($mytablesuffix,$oldtablesuffix);
		if (isset($add))
		$dataforinsert = getData($myfields, $add, $myname);

		$modulefieldsexception = "mydownloads";
		$moduletableexception = "module-exception";

		echo "<b><u>1. "._UI_PDD_PART."</u></b><br>";

		TableExists($mytables);
		TableExists($oldtables);

		if ($modulefolder[$selmodule] == $modulefieldsexception)
		{
			$fieldstochange = array ("downloads"  => array("url", "logourl", "homepage"), "mod" => array("title", "url", "logourl", "homepage"));
			$fieldsnewname = array ("downloads"  => array("url", "screenshot", "homepage"), "mod" => array("title", "url", "screenshot", "homepage"));
		}

		if ($modulefolder[$selmodule] == $moduletableexception)
		{
			$tabletochange = array('tabellenname-der-geändert-werden-muss (nur SUFFIX!! zB cat NICHT pddownloads_cat');
			$tablenewname = array('der-neue-tabellen-name(nur SUFFIX!! zB cat NICHT pddownloads_cat');
		}

		foreach ($mytables as $table_arr)
		{
			if (droptable($table_arr))
			echo "<b>Success:</b> Table <b>$table_arr</b> was <span style='color:#FF0000;font-weight:bold'>deleted</span> successfully.<br>";
			else
			{
				echo "<b>Error:</b> Table <b>$table_arr</b> could <span style='color:#FF0000;font-weight:bold'>not be deleted</span>.<br>";
				return;
			}
		}

		$id = getInfosfromModule($mydirname, "mid");
		$whattable = array("xoopscomments", "group_permission", "xoopsnotifications");
		$whatfield = array("com_modid", "gperm_modid", "not_modid");
		$what = array("comments", "permissions", "notification");

		$i = 0;
		foreach ($whattable as $entry)
		{
			if ($xoopsDB -> queryF("DELETE FROM " . $xoopsDB -> prefix($entry) . " WHERE $whatfield[$i] = $id"))
			{
				echo "<b>Success:</b> All <b>$what[$i]</b> were <span style='color:#FF0000;font-weight:bold'>delete</span> successfully.<br>";
				$i++;
			}
			else
			{
				echo "<b>Error:</b> The <b>$what[$i]</b> could <span style='color:#FF0000;font-weight:bold'>not be delete</span>.<br>";
				return;
			}
		}
		unset($id, $whattable, $whatfield, $what, $entry);

		/*
		in this step we get the tables from the selected modules, then we check if the tables exist
		and after that we make a copy of the tables with there fields
		*/

		echo "<br><b><u>2. "._UI_PDD_PART."</u></b><br>";

		$i = 0;
		foreach ($oldtables as $table_arr)
		{
			if ($xoopsDB -> queryF("CREATE TABLE " . $xoopsDB -> prefix("{$myname}_{$oldtablesuffix[$i]}") . " LIKE " . $xoopsDB -> prefix($table_arr) . "") && $xoopsDB -> queryF("INSERT INTO " . $xoopsDB -> prefix("{$myname}_{$oldtablesuffix[$i]}") . " SELECT * FROM " . $xoopsDB -> prefix($table_arr) . ""))
			{
				echo "<b>Success:</b> Table <b>$table_arr</b> was <span style='color:#FF0000;font-weight:bold'>cloned</span> successfully.<br>";
				$i++;
			}
			else
			{
				echo "<b>Error:</b> Table <b>$table_arr</b> could <span style='color:#FF0000;font-weight:bold'>not be cloned</span>.<br>";
				return;
			}
		}
		unset($table_arr, $i);

		if ($modulefolder[$selmodule] == $moduletableexception)
		TableException($tabletochange, $tablenewname, $myname);

		/* in this step, we check if the tables are all here, we want to be sure.
		after that short check-for-secure we begin to change the field if necessary.
		*/

		$i = 0;
		foreach ($oldtablesuffix as $suffix_arr)
		{
			$checktable[$i] = "{$myname}_{$suffix_arr}";
			$i++;
		}
		unset($i, $suffix_arr);

		TableExists($checktable);

		echo "<br><b><u>3. "._UI_PDD_PART."</u></b><br>";
		if (!empty($del))
		{
			$newoldtablesuffix = array_diff($oldtablesuffix, $del);
			$oldtablesuffix = $newoldtablesuffix;
			unset($newoldtablesuffix);

			foreach ($del as $table_arr)
			{
				if (isset($changed)) unset($changed);
				if (!empty($tabletochange))
				{
					if (in_array($table_arr, $tabletochange))
					$changed = 1;
				}

				if (empty($changed))
				{
					if (droptable("{$myname}_{$table_arr}"))
					echo "<b>Success:</b> Table <b>$table_arr</b> was <span style='color:#FF0000;font-weight:bold'>delete</span> successfully.<br>";
					else
					{
						echo "<b>Error:</b> Table <b>$table_arr</b> could <span style='color:#FF0000;font-weight:bold'>not be delete</span>.<br>";
						return;
					}
				}
			}
			unset($table_arr);
		}

		if (!empty($add))
		{
			$newtablesuffix = array_diff($mytablesuffix, $add);
			$mytablesuffix = $newtablesuffix;
			unset($newtablesuffix);

			foreach ($add as $table_arr)
			{
				if (isset($changed)) unset($changed);
				$query = "create table ".$xoopsDB->prefix("{$myname}_{$table_arr}")."(";
				for ($a=0; $a < sizeof($myfields[$table_arr]['Field']); $a++)
				{
					$query .= "".$myfields[$table_arr]['Field'][$a]." ";
					$query .= "".$myfields[$table_arr]['Type'][$a]." ";
					if ($myfields[$table_arr]['NULL'][$a] == '')
					$query .= "NOT NULL ";
					else
					$query .= "".$myfields[$table_arr]['NULL'][$a]." ";
					if ($myfields[$table_arr]['Default'][$a] != '')
					$query .= "default '".$myfields[$table_arr]['Default'][$a]."' ";
					$query .= "".$myfields[$table_arr]['Extra'][$a]." ";
					$query .= ", ";
				}

				for ($a=0; $a < sizeof($myfieldsindexes[$table_arr]['Key_name']); $a++)
				{
					if ($myfieldsindexes[$table_arr]['Index_type'][$a] != "BTREE")
					$query .= "".$myfieldsindexes[$table_arr]['Index_type'][$a]." ";
					if ($myfieldsindexes[$table_arr]['Non_unique'][$a] == 0)
					$query .= " Primary Key (".$myfieldsindexes[$table_arr]['Key_name'][$a].") ";
					else
					$query .= " Key ".$myfieldsindexes[$table_arr]['Key_name'][$a]." (".$myfieldsindexes[$table_arr]['Column_name'][$a].") ";
					if ($a+1 < sizeof($myfieldsindexes[$table_arr]['Key_name']))
					$query .= ", ";
				}

				$query .= ");";
				if (!empty($tablenewname))
				{
					if (in_array($table_arr, $tablenewname))
					$changed = 1;
				}

				if (empty($changed))
				{
					if ($xoopsDB -> queryF($query))
					echo "<b>Success:</b> Table <b>$table_arr</b> was <span style='color:#FF0000;font-weight:bold'>created</span> successfully.<br>";
					else
					{
						echo "<b>Error:</b> Table <b>$table_arr</b> could <span style='color:#FF0000;font-weight:bold'>not be created</span>.<br>";
						return;
					}
				}

			}
			unset($mul, $query, $pri, $table_arr);
		}

		TableExists($mytables);

		echo "<br><b><u>4. "._UI_PDD_PART."</u></b><br>";

		if ($modulefolder[$selmodule] == $modulefieldsexception)
		FieldsException($myfields, $fieldstochange, $fieldsnewname, $myname);

		foreach ($oldtablesuffix as $tables_suff)
		{
			$del = array_diff($oldfields[$tables_suff]['Field'], $myfields[$tables_suff]['Field']);
			if (isset($changed)) unset($changed);
			$count = 0;
			foreach ($del as $temp)
			{
				$query = "ALTER TABLE " . $xoopsDB -> prefix("{$myname}_{$tables_suff}") . " DROP $temp";
				if (!empty($fieldstochange) && isset($fieldstochange[$tables_suff]))
				{
					if (in_array($temp, $fieldstochange[$tables_suff]))
					$changed = 1;
				}
				if (empty($changed))
				{
					$result = $xoopsDB -> queryF($query);
					if ($result)
					$count++;
					else
					{
						echo "<b>Error:</b> Field <b> $temp </b> in Table $tables_suff could <span style='color:#FF0000;font-weight:bold'>not be delete</span>.<br>";
						return;
					}
				}
			}
			if (isset($result) && $result && $count != 0)
			echo "<b>Success:</b> $count Fields in table $tables_suff were <span style='color:#FF0000;font-weight:bold'>delete</span> successfully.<br>";
		}

		foreach ($mytablesuffix as $tables_suff)
		{
			$add2 = array_diff($myfields[$tables_suff]['Field'], $oldfields[$tables_suff]['Field']);
			if (isset($changed)) unset($changed);
			foreach ($add2 as $temp)
			{
				for ($a=0; $a < sizeof($myfields[$tables_suff]['Field']); $a++)
				{
					if ($myfields[$tables_suff]['Field'][$a] == $temp)
					{
						$b[$tables_suff][] = $a;
						$a = sizeof($myfields[$tables_suff]['Field']);
					}
				}
			}
			unset($temp);
			if (isset($b[$tables_suff]))
			{
				$count = 0;
				for ($c = 0; $c < sizeof($b[$tables_suff]); $c++)
				{
					if (isset($changed)) unset($changed);
					$query = "ALTER TABLE " . $xoopsDB -> prefix("{$myname}_{$tables_suff}") . " ADD ";
					$query .= "".$myfields[$tables_suff]['Field'][$b[$tables_suff][$c]]." ";
					$query .= "".$myfields[$tables_suff]['Type'][$b[$tables_suff][$c]]." ";
					if ($myfields[$tables_suff]['NULL'][$b[$tables_suff][$c]] == '')
					$query .= "NOT NULL ";
					else
					$query .= "".$myfields[$tables_suff]['NULL'][$b[$tables_suff][$c]]." ";
					if ($myfields[$tables_suff]['Default'][$c] != '')
					$query .= "default '".$myfields[$tables_suff]['Default'][$b[$tables_suff][$c]]."' ";
					$query .= "".$myfields[$tables_suff]['Extra'][$b[$tables_suff][$c]]." ";
					if (!empty($fieldsnewname) && isset($fieldsnewname[$tables_suff]))
					{
						if (in_array($myfields[$tables_suff]['Field'][$b[$tables_suff][$c]], $fieldsnewname[$tables_suff]))
						$changed = 1;
					}
					if (empty($changed))
					{
						$result = $xoopsDB -> queryF($query);
						if ($result)
						$count++;
						else
						{
							echo "<b>Error:</b> Field <b> ".$myfields[$tables_suff]['Field'][$b[$tables_suff][$c]]." </b> in Table $tables_suff could <span style='color:#FF0000;font-weight:bold'>not be created</span>.<br>";
							return;
						}
					}
				}
				if ($result && $count != 0)
				echo "<b>Success:</b> $count Fields in table $tables_suff were <span style='color:#FF0000;font-weight:bold'>created</span> successfully.<br>";
			}
		}

		echo "<br><b><u>5. "._UI_PDD_PART."</u></b><br>";
		if (isset($dataforinsert))
		insertData($dataforinsert, $add, $myfields, $myname);

		if ($com == 1)
		{
			$comment = array("xoopscomments");
			$commentsfields = getFields($comment, $comment);
			$commentsdata = getData($commentsfields, $comment, $myname, 1, $oldname);
			if (isset($commentsdata))
			insertData($commentsdata, $comment, $commentsfields, $myname, 1);
			unset($comment, $commentsfields, $commentsdata);
		}

		if ($perm == 1)
		{
			$perm = array("group_permission");
			$permfields = getFields($perm, $perm);
			$permdata = getData($permfields, $perm, $myname, 2, $oldname);
			if (isset($permdata))
			insertData($permdata, $perm, $permfields, $myname, 2);
			unset($perm, $permfields, $permdata);
		}

		if ($not == 1)
		{
			$not = array("xoopsnotifications");
			$notfields = getFields($not, $not);
			$notdata = getData($notfields, $not, $myname, 3, $oldname);
			if (isset($notdata))
			insertData($notdata, $not, $notfields, $myname, 3);
			unset($not, $notfields, $notdata);
		}

		if ($upgrade == 1)
		return 1;
		else
		echo "<br><h3><span style='color:#ff0000;font-weight:bold'>Importing successfully finished.</span></h3>";
	}
}

function FieldsException($myfields, $fieldstochange, $fieldsnewname, $mydirname)
{
	global $xoopsDB;

	foreach (array_keys($fieldstochange) as $keys)
	{
		for ($i = 0; $i < sizeof($fieldstochange[$keys]); $i++)
		{
			for ($a=0; $a < sizeof($myfields[$keys]['Field']); $a++)
			{
				if ($myfields[$keys]['Field'][$a] == $fieldsnewname[$keys][$i])
				{
					$b[$keys][] = $a;
					$a = sizeof($myfields[$keys]['Field']);
				}
			}
		}
		if (isset($b))
		{
			$count = 0;
			for ($a = 0; $a < sizeof($fieldstochange[$keys]); $a++)
			{
				$query = "ALTER TABLE " . $xoopsDB -> prefix("{$mydirname}_{$keys}") . " CHANGE ".$fieldstochange[$keys][$a]." ";
				$query .= "".$myfields[$keys]['Field'][$b[$keys][$a]]." ";
				$query .= "".$myfields[$keys]['Type'][$b[$keys][$a]]." ";
				if ($myfields[$keys]['NULL'][$b[$keys][$a]] == '')
				$query .= "NOT NULL ";
				else
				$query .= "".$myfields[$keys]['NULL'][$b[$keys][$a]]." ";
				if ($myfields[$keys]['Default'][$a] != '')
				$query .= "default '".$myfields[$keys]['Default'][$b[$keys][$a]]."' ";
				$query .= "".$myfields[$keys]['Extra'][$b[$keys][$a]]." ";
				$result = $xoopsDB -> queryF($query);
				if ($result)
				$count++;
				else
				{
					echo "<b>Error:</b> Could <span style='color:#ff0000;font-weight:bold'>not change</span> Field <b>".$fieldstochange[$keys][$a]."</b> in table $keys!";
					return;
				}
			}
			if ($result && $count != 0)
			echo "<b>Success:</b> $count Fields in table $keys were <span style='color:#FF0000;font-weight:bold'>changed</span> successfully.<br>";
		}
	}
}

function droptable($table)
{
	global $xoopsDB;

	return $xoopsDB -> queryF("DROP TABLE " . $xoopsDB -> prefix($table) . "");
}

function makesuffix($array)
{
	$i = 0;
	foreach ($array as $temp_arr)
	{
		$temp_split = explode("_", $temp_arr);
		$split[$i] = $temp_split[1];
		$i++;
	}
	unset($temp_arr, $i, $array, $temp_split);

	return $split;
}

function makemodulename($array)
{
	$i = 0;
	foreach ($array as $temp_arr)
	{
		$temp_split = explode("_", $temp_arr);
		$split = $temp_split[0];
	}
	unset($temp_arr, $i, $array, $temp_split);

	return $split;
}

function TableException($tabletochange, $tablenewname, $mydirname)
{
	global $xoopsDB;

	$i = 0;
	foreach ($tabletochange as $table_arr)
	{
		$result = $xoopsDB -> queryF("ALTER TABLE " . $xoopsDB -> prefix("{$mydirname}_{$table_arr}") . " RENAME " . $xoopsDB -> prefix("{$mydirname}_{$tablenewname[$i]}") . "");
		if (!$result)
		{
			echo "<b>Error:</b> Could <span style='color:#ff0000;font-weight:bold'>not change</span> Table <b>$table_arr</b>!";
			return;
		}
		else
		{
			echo "<b>Success:</b> Table <b>$table_arr</b> was <span style='color:#FF0000;font-weight:bold'>changed</span> to <b>{$mydirname}_{$tablenewname[$i]}</b> successfully.<br>";
			$i++;
		}
	}
}

function getTables($module)
{
	$module_handler =& xoops_gethandler('module');
	$module =& $module_handler->getByDirname($module);
	$tables = $module->getInfo('tables');

	return $tables;
}

function TableExists($tablename)
{
	global $xoopsDB;

	foreach ($tablename as $tableexist_arr)
	{
		$tablename = $xoopsDB->prefix($tableexist_arr);
		$result=$xoopsDB->queryF("SHOW TABLES LIKE '$tablename'");

		if (!$xoopsDB->getRowsNum($result) > 0)
		{
			echo "<b>Error:</b> Table $tableexist_arr does <span style='color:#ff0000;font-weight:bold'>not exist</span>!";
			xoops_cp_footer();
			exit();
		}
	}
	unset($tableexist_arr, $tablename, $result, $tablename);

	return true;
}

function findmodules($findfolder=0, $mydirname)
{
	$moduleprefix = array("my", "wf", "pd");

	$i = 0;
	for ($a = 0; $a < sizeof($moduleprefix); $a++)
	{
		if (SearchModule("pddownloads$a") && "pddownloads$a" != $mydirname)
		{
			if ($findfolder == 1) $infos[$i] = "pddownloads$a";
			else $infos[$i] = getInfosfromModule("pddownloads$a", "name");
			$i++;
		}
		if (SearchModule("$moduleprefix[$a]downloads") && "$moduleprefix[$a]downloads" != $mydirname)
		{
			if ($findfolder == 1) $infos[$i] = "$moduleprefix[$a]downloads";
			else $infos[$i] = getInfosfromModule("$moduleprefix[$a]downloads", "name");
			$i++;
		}
	}

	unset($i, $a, $moduleprefix);

	if (isset($infos))
	return $infos;
}

function getFields($tables, $suffix)
{
	global $xoopsDB;

	error_reporting(0);

	$i = 0;
	foreach ($tables as $table_arr)
	{
		$result=$xoopsDB->queryF("SHOW FIELDS FROM " . $xoopsDB -> prefix($table_arr) . "");

		while ($row = $xoopsDB->fetchArray($result))
		{
			$fields[$suffix[$i]]['Field'][] = $row['Field'];
			$fields[$suffix[$i]]['Type'][] = $row['Type'];
			$fields[$suffix[$i]]['NULL'][] = $row['NULL'];
			$fields[$suffix[$i]]['Default'][] = $row['Default'];
			$fields[$suffix[$i]]['Extra'][] = $row['Extra'];
		}
		$i++;
	}

	error_reporting(E_ALL);
	unset($tables, $table_arr, $result, $row, $i, $suffix);
	return $fields;
}

function getFieldsIndexes($tables, $suffix)
{
	global $xoopsDB;

	error_reporting(0);

	$i = 0;
	foreach ($tables as $table_arr)
	{
		$result=$xoopsDB->queryF("SHOW INDEXES FROM " . $xoopsDB -> prefix($table_arr) . "");

		while ($row = $xoopsDB->fetchArray($result))
		{
			$fields[$suffix[$i]]['Key_name'][] = $row['Key_name'];
			$fields[$suffix[$i]]['Column_name'][] = $row['Column_name'];
			$fields[$suffix[$i]]['Non_unique'][] = $row['Non_unique'];
			$fields[$suffix[$i]]['Index_type'][] = $row['Index_type'];
		}
		$i++;
	}

	error_reporting(E_ALL);
	unset($tables, $table_arr, $result, $row, $i, $suffix);
	return $fields;
}

function getData($field, $suffix, $mydirname, $options=0, $oldname='')
{
	global $xoopsDB;

	if ($options != 0)
	{
		$id = getInfosfromModule($oldname, "mid");
		$request = $suffix[0];
		if ($options == 1)
		$where = array("com_modid", $id);
		else if ($options == 2)
		$where = array("gperm_modid", $id);
		else if ($options == 3)
		$where = array("not_modid", $id);
	}

	foreach ($suffix as $table_arr)
	{
		if ($options == 0)
		$request = "{$mydirname}_{$table_arr}";

		$query = "SELECT * FROM " . $xoopsDB -> prefix($request) . "";
		if ($options != 0)
		$query .= " WHERE ".$where[0]." = ".$where[1]."";

		$result=$xoopsDB->queryF($query);
		$size = sizeof($field[$table_arr]['Field']);

		$a = 0;
		while ($row = $xoopsDB->fetchArray($result))
		{
			for ($i = 0; $i < $size ; $i++)
			{
				$data[$table_arr][$a][] = $row[$field[$table_arr]['Field'][$i]];
			}
			$a++;
		}
	}
	if (isset($data))
	return $data;
}

function insertData($data, $suffix, $fields, $mydirname, $options=0)
{
	global $xoopsDB;

	if ($options != 0)
	{
		$id = getInfosfromModule($mydirname, "mid");
		$request = $suffix[0];
		if ($options == 1)
		$where = array("com_modid", $id, "comments");
		else if ($options == 2)
		$where = array("gperm_modid", $id, "permissions");
		else if ($options == 3)
		$where = array("not_modid", $id, "notification settings");
	}

	foreach ($suffix as $table_arr)
	{
		if ($options == 0)
		$request = "{$mydirname}_{$table_arr}";

		if (isset($data[$table_arr]))
		{
			for ($b=0; $b < sizeof($data[$table_arr]); $b++)
			{
				$query = "INSERT INTO " . $xoopsDB -> prefix($request) . " VALUES (";

				for ($a=0; $a < sizeof($fields[$table_arr]['Field']); $a++)
				{
					if ($options == 0)
					{
						if ($data[$table_arr][$b][$a] == '')
						$query .= "' ' ";
						else
						$query .= "'".$data[$table_arr][$b][$a]."' ";
					}

					else
					{
						if ($a == 0)
						$query .= "''";
						else if ($a == 1 && $options == 3)
						$query .= "".$where[1]."";
						else if ($a == 3 && $options != 3)
						$query .= "".$where[1]."";
						else if ($a == 4 && $options == 2)
						{
							if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
							$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

							$moduleprefix = array("WF", "PD");
							$what = array("DownCatPerm","DownFilePerm");

							$i = 0;

							for ($c = 0; $c < sizeof($what); $c++)
							{
								if ($data[$table_arr][$b][$a] == "$moduleprefix[0]$what[$c]")
								{
									$iswf = 1;
									$query .= "'$moduleprefix[1]$what[$c]$mydirnumber'";
								}
							}

							if (empty($iswf))
							{
								for ($c = 0; $c < sizeof($what); $c++)
								{
									if (substr_count($data[$table_arr][$b][$a], $what[$c]) > 0)
									$query .= "'$moduleprefix[1]$what[$c]$mydirnumber'";
								}
							}
						}
						else if ($data[$table_arr][$b][$a] == '')
						$query .= "' ' ";
						else
						$query .= "'".$data[$table_arr][$b][$a]."' ";
					}

					if ($a+1 < sizeof($fields[$table_arr]['Field']))
					$query .= ", ";

				}
				$query .= ");";
				$result = $xoopsDB -> queryF($query);
				if (!$result)
				{
					echo "<b>Error:</b> Could <span style='color:#ff0000;font-weight:bold'>not import</span> data into table <b>$table_arr</b>!";
					return;
				}
			}
			if (isset($result) && $result && $options == 0)
			echo "<b>Success:</b> <span style='color:#FF0000;font-weight:bold'>Imorting</span> data into table <b>$table_arr</b> was a success.<br>";
			else if (isset($result) && $result && $options != 0)
			echo "<b>Success:</b> <span style='color:#FF0000;font-weight:bold'>Imorting</span> ".$where[2]." was a success.<br>";
		}
	}
}

if (!isset($_POST['op']))
$op = isset($_GET['op']) ? $_GET['op'] : 'main';
else
$op = $_POST['op'];

switch ($op)
{
	case "import":
	import();
	break;

	case "upgrade":
	upgrade();
	break;

	case "main":
	default:

	echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_PDD_UANDITOOL ." ". _UI_PDD_INFO . "</legend>\n
			<div style='padding: 8px;'>" . _UI_PDD_INFOTEXT . "</div>\n</fieldset>\n";

	$downloadmodules = findmodules(0, $mydirname);

	$sform = new XoopsThemeForm(_UI_PDD_SELMODULE, "op", xoops_getenv('PHP_SELF'), "post", true);
	$choosemodule = new XoopsFormSelect(_UI_PDD_CHOOSEMODULE, 'selmodule', -1, sizeof($downloadmodules));
	$choosemodule->addOptionArray($downloadmodules);
	$thisismymodule = new XoopsFormLabel(_UI_PDD_ACTUALMODUL, getInfosfromModule($mydirname, "name"));
	$sform ->addElement($choosemodule, true);
	$sform ->addElement($thisismymodule);

	if ($downloadmodules > 0)
	{
		$options_tray = new XoopsFormElementTray(_UI_PDD_OPTIONS, '<br />');

		$comments_checkbox = new XoopsFormCheckBox('', 'com');
		$comments_checkbox -> addOption(1, _UI_PDD_WANTCOM);
		$options_tray -> addElement($comments_checkbox);

		$notification_checkbox = new XoopsFormCheckBox('', 'not');
		$notification_checkbox -> addOption(1, _UI_PDD_WANTNOT);
		$options_tray -> addElement($notification_checkbox);

		$perm_checkbox = new XoopsFormCheckBox('', 'perm');
		$perm_checkbox -> addOption(1, _UI_PDD_WANTPERM);
		$options_tray -> addElement($perm_checkbox);

		$button_tray = new XoopsFormElementTray('', '');
		$button_tray -> addElement(new XoopsFormHidden('op', ''));

		$button_upgrade = new XoopsFormButton('', '', _UI_PDD_UPGRADE, 'submit');
		$button_upgrade -> setExtra('onclick="this.form.elements.op.value=\'upgrade\'"');

		$button_import = new XoopsFormButton('', '', _UI_PDD_IMPORT, 'submit');
		$button_import -> setExtra('onclick="this.form.elements.op.value=\'import\'"');

		$button_cancel = new XoopsFormButton('', '', _AM_PDD_BCANCEL, 'button');
		$button_cancel -> setExtra('onclick="history.go(-1)"');

		$button_tray -> addElement($button_upgrade);
		$button_tray -> addElement($button_import);
		$button_tray -> addElement($button_cancel);
		$sform ->addElement($options_tray);
		$sform ->addElement($button_tray);
	}

	$sform ->display();

	break;
}
xoops_cp_footer();
?>