<?php
/*
 *  Copyright (c) 2008, Kay Haefker. All rights reserved.
 *
 *  This program is free software: you can redistribute it and/or modify
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

if(!defined(THIS))
{
  die();
}
class mysql_installer
{
	// constructor
	function mysql_installer($params = null)
	{
    //$this->db_user = $params['db_user'];
    //$this->db_pass = $params['db_pass'];

		$hostname = "localhost";
    //$port = "3306";
    //$db_user = "root";
    //$db_pass = "";
  }

  //DB User Name
  function getUN()
  {
     return $this->db_user;
  }

  function setUN( $db_user = null )
  {
     $this->db_user = $db_user;
  }

  //DB User Password
  function getPW()
  {
     return $this->db_pass;
  }

  function setPW( $db_pass = null )
  {
     $this->db_pass = $db_pass;
  }

	// DB Connection
	function db_connect($db_host = '')
  {
    $db_user = $this->getUN();
    $db_pass = $this->getPW();
    $result = @mysql_connect($db_host, $db_user, $db_pass) or die(mysql_errno().": ".$db_host." ".$db_user." Can't connect to MySQL Server (10061)");
    if (!$result)
      return false;
    return $result;
  }

  // Create Database (portal_auth & portal_db)
  function create_db($new_db)
  {
  	if(!$new_db)
  		return fasle;
  	if (mysql_create_db ($new_db))
		{
    	print("Database ".$new_db." successfully created");
    }
		else
		{
    	print("Error creating database: ".mysql_error());
    }
  }

  // Execute SQL-Script
  function exec_query($query)
  {
		$conn = $this->db_connect();
    foreach( $query as $q_row )
		{
			$result = mysql_query($q_row);
      if (!$result)
      	return false;
    }
    return true;
  }

  // User Interface (get user name & password)
  function start_installation()
  {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head><title>Sch&uuml;lerportal Datenbankinstallation</title></head>
  <body>
    <h1>Datenbankinstallationsskript</h1>
    <form id="install_form" method="post" action="<?php echo $_SERVER[PHP_SELF]; ?>">
      <p>
        Datenbankbenutzername:<br /><input type="text" name="db_user" /><br />
        Datenbankbenutzerpasswort:<br /><input type="password" name="db_pass" /><br />
        Best&auml;tigen:<br /><input type="submit" value="Installieren" />
      </p>
    </form>
  </body>
</html>
<?
  }
}
?>