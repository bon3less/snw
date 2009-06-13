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

  define('THIS', 'true');
  $snw_root = './';
  include($snw_root.'common/lib.inc.php');

  // defining some urls for redirection
  $url = Redirection::get_base_url();
  $target1 = "index.php"; 

  // protection
  $param=false;
  if ($_GET) $param=$_GET;
  if (!$param) Redirection::redirect($url.$target1); // TODO: redirecting to main login.php page
  // start session
  session_start();
  if (!(session_is_registered("this_user"))) // not logged on
  {
    $info_msg = array( "logout" => "NOT LOGGED ON !!!" );
    if ( is_array( $_SESSION['info_msg'] ) )
      $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
    else
      $_SESSION['info_msg'] = $info_msg;
    Redirection::redirect($url.$target1);
  }
  else
  {  
    // logout process
    if ($param['logout'] == 1);
    {
      $user = $_SESSION['user_obj'];
      $logout = $user->logout();
      
      if ($logout)
      {
        $info_msg = array( "logout" =>  "Logged out." );
        if ( is_array( $_SESSION['info_msg'] ) )
          $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
        else
          $_SESSION['info_msg'] = $info_msg;
        Redirection::redirect($url.$target1);
      }
      else
      {
        $error_msg = array( "logout" =>  "User can't be logged out." );
        if ( is_array( $_SESSION['error_msg'] ) )
          $_SESSION['error_msg'] = array_merge( $_SESSION['error_msg'], $error_msg);
        else
          $_SESSION['error_msg'] = $error_msg;
        Redirection::redirect($url.$target1);
      }
    }
  }  
?>