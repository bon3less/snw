<?php
/*
 *  Copyright (c) 2008, Kay Haefker. All rights reserved.
 *
 *  This
 program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */

//if(!defined(THIS))
//{
//  die("ERROR!");
//}
//if (!defined(THIS))
//{
//  define ('THIS', 'true');
//}
require_once("../../lib.inc.php");
$post_array = $HTTP_POST_VARS;
if(count($post_array) > 0)
{
	$query_authDB = file("../db/portal_auth.sql");
  $query_DB = file("../db/portal_db.sql");
	if (!$query_authDB || !$query_DB)
	{
		print("Error: One or more SQL-files do not exist ( portal_auth.sql, portal_db.sql ).<br />The files need to be in /common/db directory.");
	}
	else
	{
    $config['db_user'] = $_POST['db_user'];
    $config['db_pass'] = $_POST['db_pass'];
   
    $installation = new mysql_installer($config);
    $installation->setUN($_POST['db_user']);
    $installation->setPW($_POST['db_pass']);
    
    $result = $installation->exec_query($query_authDB);
    if (!$result)
    {
    	print("Creating the database portal_auth faild: <br /><br />");
    }
    else
    {
    	print("Database portal_auth successfully created. <br /><br />");
  		$result = $installation->exec_query($query_DB);
    	if (!$result)
      { echo $result;
      	print("Creating the database portal_db faild <br /><br />");
      }
      else
      	print("Database portal_db successfully created. <br /><br />");
    }
  }
}
else
{
	$installation = new mysql_installer();
	$installation->start_installation();
}
?>