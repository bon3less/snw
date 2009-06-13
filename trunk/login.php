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

  // defining some urls
  $url = Redirection::get_base_url();

  // protection
  $param=false;
  if ($_POST) $param=$_POST;
  if (!$param) Redirection::redirect($url."index.php"); // TODO: redirecting to main login.php page
  // SESSION START
  session_start();
  if ( session_is_registered("this_user") )
  {
    $session = Session_manager::singleton($_SESSION['this_user_id']);
    $info_msg = array( "login" => "Dieser Benutzer ist schon angemeldet");
    if ( is_array( $_SESSION['info_msg'] ) )
      $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
    else 
      $_SESSION['info_msg'] = $info_msg;
  }
  elseif (!(session_is_registered("this_user")))
  {
    // start session manager
    $session = Session_manager::singleton();
    // check for spam
    $spam = null;
    $max = $session->get_max_session_life_time();
    $spam = new Spam_blocker($max);
    if ( $spam->check_request() )
    {
      $error_msg = array( 'spam' => "SPAM DETECTED! ACCOUNT BLOCKED!");
      if ( is_array( $_SESSION['error_msg'] ) )
        $_SESSION['error_msg'] = array_merge( $_SESSION['error_msg'], $error_msg);
      else
        $_SESSION['error_msg'] = $error_msg;
      Redirection::redirect($url."index.php");
    }
    else
    {
      // defining some urls for redirection
      $url = Redirection::get_base_url();
      $cat = $param['page'];
      $target = "cat.php?cat=$cat";
      if ($cat == 0 || !(isset($cat)) )
        $target = "index.php";
      // ceate user object and  checking login infomation
      $param_arr = Split_array::to_param_arr_user($param);
      $param = null;
      $user = new User($param_arr);
      $user_validator = User_validator::singleton($user);
      $login_exists = $user_validator->check_login();
      if ( $login_exists )
        $uid = $user->get_user_id();
      if ( $uid > 0 )
      {
        // login this user
        $session = $user->login();
        $_SESSION['user_obj'] = $user;
        Session_object_handler::add_object("pupil", $uid);
        $pupil = $_SESSION['pupil'];
        $aid = $pupil->get_address_id();
        $sid = $pupil->get_school_id();
        $gid = $pupil->get_grade_id();
        Session_object_handler::add_object("pupil_address", $aid);
        Session_object_handler::add_object("school", $sid);
        Session_object_handler::add_object("grade", $gid);
        Redirection::redirect($url.$target1);
      }
      else
      {
        // redirect and throw an error message to the user
        $info_msg = array( "login" => "Benutzername oder Passwort unkorrekt!");
        if ( is_array( $_SESSION['info_msg'] ) )
          $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
        else 
          $_SESSION['info_msg'] = $info_msg;
        Redirection::redirect($url.$target);
      }
    }
  }
  else
  {
    $error_msg = array( 'login' => 'ERROR: '. session_id());
    if ( is_array( $_SESSION['error_msg'] ) )
      $_SESSION['error_msg'] = array_merge( $_SESSION['error_msg'], $error_msg);
    else
      $_SESSION['error_msg'] = $error_msg;
  }
?>











