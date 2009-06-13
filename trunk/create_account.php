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
  $target = "index.php";

  // protection post intrusion
  $param=false;
  if ($_POST) $param=$_POST;
  if (!$param) Redirection::redirect($url.$target);

  // session start
  session_start();
  if (!(session_is_registered("this_user"))) // not logged on
    $session = Session_manager::singleton();
  else
    $session = Session_manager::singleton(@$_SESSION['this_user_id']);
  @$_SESSION['error_msg'] = "";
  @$_SESSION['info_msg']  = "";
  // check for spam
  $spam = null;
  $max = $session->get_max_session_life_time();
  $spam = new Spam_blocker($max);
  //$mail_birth = pow(2,15) - pow(2,11) - 1;
  //$mail_age   = pow(2,15) - pow(2,12) - 1;
  $mail   = pow(2,13) - pow(2,12) - 1;
  if ( $spam->check_request() )
  {
    Redirection::redirect($url."index.php");
    //TODO: perhaps some logging
  }
  else
  {
    //if ( !( @$param['mail'] == $mail_birth || @$param['mail'] == $mail_age ))
    if ( !( @$param['mail'] == $mail) )
    {
      $error_msg = array( 'form_mail' =>  "Fehler: Das Anmeldeformulat ist nicht korrekt ausgef&uuml;llt worden! ");
      if ( is_array( $_SESSION['error_msg'] ) )
        $_SESSION['error_msg'] = array_merge( $_SESSION['error_msg'], $error_msg);
      else
        $_SESSION['error_msg'] = $error_msg;
      Redirection::redirect($url."cat.php?cat=5");
    }
    else
    {
      // TODO: RegEx $param (post array)
//      $regstr=/^[A-Za-zִײÜהצüß \-\.]{2,50}|[A-Za-zִײÜהצüß \-\.]{2,50}?[0-9]{1,4}?$/; // street
//      $regnr=/^([1-9][0-9]{0,3})([a-zA-Z]{1})?(-([1-9][0-9]{0,3})([a-zA-Z]{1})?)?$/; // house number
//      $regplz=/^(\d{5})$|^(\d{4})$/;
//      $reggeb=/^([0]?[1-9]|[1|2][0-9]|[3][0|1])[.\/-]([0]?[1-9]|[1][0-2])[.\/-]([1|2][0-9]{3})$/; // date
//      $regpass=/^(?=^.{6,16}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/; // password min 1x upper case & min 1x lower case & min 1 x digit
//      $regnick=/^([a-zA-Z0-9_\-]+){2,12}$/; // alle zahlen, buchstaben und unterstrich
//      $regid=/^([a-zA-Z0-9_\-]+){4,12}$/;
//      $regemail=/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4})(\]?)$/; // regex email
//      $regschule=/^[A-ZִײÜ1-9]+(([\'\.\- ][a-zA-ZִײÜהצüß ])?[a-zA-ZִײÜהצüß]*)*$/; //regex name (german)
//      $regname=/^[A-ZִײÜ]+(([\'\.\- ][a-zA-ZִײÜהצüß ])?[a-zA-ZִײÜהצüß]*)*$/; //regex name (german)
//      $regurl =/^((http|https):\/\/)([\w.]+(\/)?)+[A-Za-z\/]|((http|https):\/\/)$/;  // regex url
//      $reggrade=/^(([1][0-3])([.\/-]?[a-zA-Z0-9]{1,2})?)|(([0]?[1-9])([.\/-]?[a-zA-Z0-9]{1,2})?)$/ // school grade
//      $regage=/^[1-9][0-9]?$/;
//      $regcell=/^[+]?[0-9\-\/ ]{8,}$/;
//      $regskype = /^[0-9]{5,}$/;
//      $regicq = /^[0-9\-]{9,11}$/;
//      $regmsg_id = /^([a-zA-Z0-9_@\-\.]{2,})$/;

      // split post array
      $param_arr_user    = Split_array::to_param_arr_user($param);
      $param_arr_school  = Split_array::to_param_arr_school($param);
      $param_arr_grade   = Split_array::to_param_arr_grade($param);
      $param_arr_pupil   = Split_array::to_param_arr_pupil($param);
      $param_arr_address = Split_array::to_param_arr_address($param);
      $param = null;
      // create objects
      $user    = new User($param_arr_user);
      $school  = new School($param_arr_school);
      $grade   = new Grade_of_school($param_arr_grade);
      $pupil   = new Pupil($param_arr_pupil);
      $address = new Address_pupil($param_arr_address);
      // start registration process
      $registration = new Registration($user, $school, $grade, $address, $pupil);
      // error and user info
      $error_msg = $registration->get_error_messages();
      $info_msg  = $registration->get_info_messages();
      if ( is_array( $_SESSION['error_msg'] ) )
        $_SESSION['error_msg'] = array_merge( $_SESSION['error_msg'], $error_msg);
      else
        $_SESSION['error_msg'] = $error_msg;
      if ( is_array( $_SESSION['info_msg'] ) )
        $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
      else
        $_SESSION['info_msg'] = $info_msg;
      Redirection::redirect($url.$target);
    }
    die('Fatal Error: create_account.php');
  }
?>