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
  function db_config()
  {
    //* MySQL remote
    $db_host = "";  // must be encrypted
    $db_user = "";  // must be encrypted
    $db_pass = "";  // must be encrypted
    $db_name = "";  // must be encrypted
    //*/

    $config = array(  'db_host' => $db_host,
                      'db_user' => $db_user,
                      'db_pass' => $db_pass,
                      'db_name' => $db_name);
    
    return $config;
  }
?>