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

/******************************************************************************
 * class Registration
 */
class Registration
{
  private static $mysql;
  private $user;
  private $school;
  private $grade;
  private $address;
  private $pupil;
  private $error_messages = "";   // infos for the admin
  private $info_messages  = "";   // infos for the user

  /////////////////////////////////////////////////////////////////////////
  // constuctor
  public function __construct($user, $school, $grade, $address, $pupil)
  {
    // set objects vars
    $this->user    = $user;
    $this->school  = $school;
    $this->grade   = $grade;
    $this->address = $address;
    $this->pupil   = $pupil;
    // create db connection instance
    $config_arr = Serialization::convert();
    $this->mysql = Mysql_Class::singleton($config_arr);
    // validation
    $counter = $this->init_check();
    // make db enrties
    if ($counter == 0)
      $this->init_account_creation();
    elseif ( $counter == 4 || $counter == 8 || $counter == 12 )
      $this->init_account_creation($counter);
  }
  /////////////////////////////////////////////////////////////////////////
  // initializes the check process
  private function init_check()
  {
    $counter = 0;
    $ok = $this->check_user_id();
    if ($ok) $ok = $this->check_school();
    else {$counter += 2; $ok = $this->check_school();}
    if ($ok) $ok = $this->check_grade();
    else {$counter += 4; $ok = $this->check_grade();}
    if ($ok) $ok = $this->check_pupil();
    else {$counter += 8; $ok = $this->check_pupil();}
    if ($ok) $ok = $this->check_address();
    else {$counter += 16; $ok = $this->check_address();}
    return $counter;
  }
  /////////////////////////////////////////////////////////////////////////
  // initializes the check process
  private function init_account_creation($counter = 0)
  {
    $this->add_user();
    if (($counter & 4 ) == 0)
      $this->add_school();
    if (($counter & 8 ) == 0)
      $this->add_grade();
    $this->add_pupil();
    $this->add_address();
  }
  /////////////////////////////////////////////////////////////////////////
  // check if this user id is taken already
  public function check_user_id( $flag = true )
  {
    $user_login = $this->user->get_user_login();
    if (!isset($user_login))
      return true;
    $user_login = md5(Serialization::encode($user_login));
    $query = "SELECT `User_id` FROM `Schueler_Login` WHERE `user_Login` = '$user_login';";
    $this->mysql->query($query);
    $result = $this->mysql->get_result_field();
    if ( $result > 0)
    {
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_user' => "Dieser Benutzername ist schon vergeben!"));
      else
        $this->info_messages = array( 'check_user' => "Dieser Benutzername ist schon vergeben!");
      return false;
    }
    elseif ( $flag == true )
    {
      return true;
    }
    else
    {
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_user' => "Der Benutzername ist frei."));
      else
        $this->info_messages = array( 'check_user' => "Der Benutzername ist frei." );
    }
  }
  /////////////////////////////////////////////////////////////////////////
  // add user in the db
  private function add_user()
  {
    $user_login = $this->user->get_user_login();
    $password   = $this->user->get_user_password();
    if ( !isset($user_login) || !isset($password))
      die("Error: OMITTED VAR VALUE -> add_user() in file ". __file__ ." line ". __line__);
    $date = time();
    $sess_id = session_id();
    $user_login = md5(Serialization::encode($user_login));
    $password   = md5(Serialization::encode($password));
    $query = "INSERT INTO `Schueler_Login` (`user_Login`,  `password`, `anmelde_Datum`, `session_id`)
              VALUES                       ('$user_login', '$password', '$date',         '$sess_id');";
    $this->mysql->query($query);
    $uid = $this->mysql->insertid();
    if ( $uid > 0 )
    {
      $this->user->set_user_id($uid);
      $this->pupil->set_user_id($uid);
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'add_user' => "Benutzerkonto wurde erfolgreich erstellt!"));
      else
        $this->info_messages = array( 'add_user' => "Benutzerkonto wurde erfolgreich erstellt!" );
    }
    else
      die("Error: NO USER ID -> add_user() in file ". __file__ ." line ". __line__);
  }
  /////////////////////////////////////////////////////////////////////////
  // check if this school exist in db already
  public function check_school( $flag = true )
  {
    $school_name      = $this->mysql->db_escape($this->school->get_school_name());
    $school_country   = $this->mysql->db_escape($this->school->get_land_id());
    $school_province  = $this->mysql->db_escape($this->school->get_school_kanton());
    $school_city      = $this->mysql->db_escape($this->school->get_school_ort());
    $query = "SELECT  `Schul_ID`
              FROM    `Schule`
              WHERE   `schul_Name`  = '$school_name'
              AND     `Land_ID`     = '$school_country'
              AND     `bundesland`  = '$school_province'
              AND     `ort`         = '$school_city';";
    $this->mysql->query($query);
    $schul_id = $this->mysql->get_result_field();
    if ( $schul_id > 0 )
    {
      $this->school->set_school_id($schul_id);
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_school' => "Diese Schule ist bereits eingetragen!"));
      else
        $this->info_messages = array( 'check_school' => "Diese Schule ist bereits eingetragen!" );
      return false;
    }
    elseif ( $flag == true )
    {
      return true;
    }
    else
    {
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_school' => "Diese Schule ist noch nicht eingetragen!"));
      else
        $this->info_messages = array( 'check_school' => "Diese Schule ist noch nicht eingetragen!" );
    }
  }
  /////////////////////////////////////////////////////////////////////////
  // add school into the db
  private function add_school()
  {
    $school_country   = $this->school->get_land_id();
    $school_zip       = $this->school->get_school_plz();
    $school_street_no = $this->school->get_school_str_nr();
    $homepage         = $this->mysql->db_escape($this->school->get_school_url());
    $school_name      = $this->mysql->db_escape($this->school->get_school_name());
    $school_city      = $this->mysql->db_escape($this->school->get_school_ort());
    $school_province  = $this->mysql->db_escape($this->school->get_school_kanton());
    $school_street    = $this->mysql->db_escape($this->school->get_school_strasse());

    if ( !isset($school_name) || !isset($school_country) || !isset($school_city) || !isset($school_province))
      die("Error: OMITTED VAR VALUE -> add_school() in file ". __file__ ." line ". __line__);

    $query = "INSERT INTO `Schule` (`schul_Name`,   `Land_ID`,         `plz`,         `ort`,           `bundesland`,        `schul_Strasse`,  `schul_Strassen_Nr`, `home_Page`)
              VALUES               ('$school_name', '$school_country', '$school_zip',  '$school_city', '$school_province',  '$school_street', '$school_street_no', '$homepage');";
    $this->mysql->query($query);
    $school_id = $this->mysql->insertid();
    if ( $school_id > 0 )
    {
      $this->school->set_school_id($school_id);
      $this->grade->set_school_id($school_id);
      $this->pupil->set_school_id($school_id);
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'add_school' => "Die Schule wurde erfolgreich eingetragen!"));
      else
        $this->info_messages = array( 'add_school' => "Die Schule wurde erfolgreich eingetragen!" );
    }
    else
      die("Error: NO SCHOOL ID -> add_school() in file ". __file__ ." line ". __line__);
  }
  /////////////////////////////////////////////////////////////////////////
  // check if this school grade exist in db already
  public function check_grade( $flag = true )
  {
    $grade_name = $this->mysql->db_escape($this->grade->get_grade_name());
    $school_id   = $this->school->get_school_id();
    $query = "SELECT  `Klassen_ID`
              FROM    `Klassen`
              WHERE   `Schul_ID`      = '$school_id'
              AND     `klassen_Name`  = '$grade_name';";
    $this->mysql->query($query);
    $grade_id = $this->mysql->get_result_field();
    if ( $grade_id > 0 )
    {
      $this->grade->set_grade_id($grade_id);
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_grade' => "Diese Klasse ist bereits eingetragen!"));
      else
        $this->info_messages = array( 'check_grade' => "Diese Klasse ist bereits eingetragen!" );
      return false;
    }
    elseif ( $flag == true )
    {
      return true;
    }
    else
    {
      $this->info_messages = array_merge( $this->info_messages, array( 'check_grade' => "Diese Klasse ist noch nicht eingetragen."));
    }
  }
  /////////////////////////////////////////////////////////////////////////
  // add grade into the portal_db
  public function add_grade()
  {
    $school_id  = $this->school->get_school_id();
    $grade_name = $this->mysql->db_escape($this->grade->get_grade_name());
    if ( !isset($school_id) || !isset($grade_name) )
      die("Error: OMITTED VAR VALUE -> add_grade() in file ". __file__ ." line ". __line__);

    $query = "INSERT INTO `Klassen` (`schul_ID`,   `klassen_Name`)
              VALUES                ('$school_id', '$grade_name');";
    $this->mysql->query($query);
    $grade_id = $this->mysql->insertid();
    if ( $grade_id > 0 )
    {
      $this->grade->set_grade_id($grade_id);
      $this->pupil->set_grade_id($grade_id);
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'add_grade' => "Klasse erfolgreich eingetragen!"));
      else
        $this->info_messages = array( 'add_grade' => "Klasse erfolgreich eingetragen!" );
    }
    else
      die("Error: NO GRADE ID -> add_grade() in file ". __file__ ." line ". __line__);
  }
  /////////////////////////////////////////////////////////////////////////
  // check if this nick name exist in db already
  private function check_pupil( $flag = true )
  {
    $nickname = $this->mysql->db_escape($this->pupil->get_nick_name());
    $query = "SELECT  `SID`
              FROM    `Schueler`
              WHERE   `nick_Name`  = '$nickname';";
    $this->mysql->query($query);
    $result = $this->mysql->get_result_field();
    if ( $result > 0 )
    {
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_pupil' => "Dieser Nickname ist schon vergeben!"));
      else
        $this->info_messages = array( 'check_pupil' => "Dieser Nickname ist schon vergeben!" );
      return false;
    }
    elseif ( $flag == true )
    {
      return true;
    }
    else
    {
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'check_pupil' => "Dieser Nickname ist noch frei."));
      else
        $this->info_messages = array( 'check_pupil' => "Dieser Nickname ist noch frei." );
    }
  }
  /////////////////////////////////////////////////////////////////////////
  // add pupil into the portal_db
  public function add_pupil()
  {
    $age        = $this->pupil->get_age();
    $gender     = $this->pupil->get_gender();
    $uid        = $this->user->get_user_id();
    $grade_id   = $this->grade->get_grade_id();
    $school_id  = $this->school->get_school_id();
    $newsletter = $this->pupil->get_newsletter_status();
    $email      = $this->mysql->db_escape($this->pupil->get_email());
    $icq        = $this->mysql->db_escape($this->pupil->get_icq_no());
    $msn        = $this->mysql->db_escape($this->pupil->get_msn_id());
    $aim        = $this->mysql->db_escape($this->pupil->get_aim_id());
    $yahoo      = $this->mysql->db_escape($this->pupil->get_yahoo_id());
    $skype      = $this->mysql->db_escape($this->pupil->get_skype_no());
    $nickname   = $this->mysql->db_escape($this->pupil->get_nick_name());
    $birth      = $this->mysql->db_escape($this->pupil->get_birthdate());
    $cell_no    = $this->mysql->db_escape($this->pupil->get_mobile_no());
    $about_me   = $this->mysql->db_escape($this->pupil->get_profil_info());

    if ( !isset($uid) || !isset($grade_id) || !isset($school_id)  || !isset($nickname) || !isset($email)  || !isset($newsletter) || !isset($gender) )
      die("Error: OMITTED VAR VALUE -> add_pupil() in file ". __file__ ." line ". __line__ .".");
    $query = "INSERT INTO `Schueler` (`User_ID`, `LID`, `Klassen_ID`, `Adress_ID`, `Schul_ID`,   `nick_Name`, `email`,  `status` , `geburtstag`, `handy_Nr`, `icq_Nr`, `skype_Nr`, `msn-id`, `yahoo-id`, `aim-id`, `kontakt_Info`, `newsletter_Status`, `alter`, `geschlecht`)
              VALUES                 ('$uid',     0,    '$grade_id',   0,          '$school_id', '$nickname', '$email',  0,        '$birth',     '$cell_no', '$icq',   '$skype',   '$msn',   '$yahoo',   '$aim',   '$about_me',    '$newsletter',       '$age',  '$gender');";
    $this->mysql->query($query);
    $pupil_id = $this->mysql->insertid();
    if ( $pupil_id > 0 )
    {
      $this->pupil->set_pupil_id($pupil_id);
      $this->address->set_pupil_id($pupil_id);
      // insert relations (grade-pupil & school-pupil)
      $query = "INSERT INTO `Klassen_Mitglieder` (`SID`,       `LID`, `Klassen_ID`)
                VALUES                           ('$pupil_id', '0',   '$grade_id');";
      $this->mysql->query($query);
      $grade_member_id = $this->mysql->insertid();
      if ( !($grade_member_id > 0) )
        die("Error: OMITTED VAR VALUE -> add_pupil() in file ". __file__ ." line ". __line__ .".");
      $query = "INSERT INTO `Schule_Mitglieder` (`SID`,       `LID`, `Schul_ID`)
                VALUES                           ('$pupil_id', '0',   '$school_id');";
      $this->mysql->query($query);
      $grade_member_id = $this->mysql->insertid();
      if ( !($grade_member_id > 0) )
        die("Error: OMITTED VAR VALUE -> add_pupil() in file ". __file__ ." line ". __line__ .".");
      if ( is_array( $this->info_messages ) )
        $this->info_messages = array_merge( $this->info_messages, array( 'add_pupil' => "Sch&uuml;ler $nickname erfolgreich angemeldet!"));
      else
        $this->info_messages = array( 'add_pupil' => "Sch&uuml;ler $nickname erfolgreich angemeldet!" );
    }
    else
      die("Error: NO PUPIL ID -> add_pupil() in file ". __file__ ." line ". __line__ .".");
  }
  /////////////////////////////////////////////////////////////////////////
  // check if this user address exists
  public function check_address( $flag = true )
  {
    //TODO: check if this user address exists
    if ( $flag == true)
      return true;
      //$this->add_address();
  }
  /////////////////////////////////////////////////////////////////////////
  // add grade into the portal_db
  public function add_address()
  {
    $pupil_id   = $this->pupil->get_pupil_id();
    $zip        = $this->address->get_zip_code();
    $country_id = $this->address->get_country_id();
    $house_no   = $this->address->get_house_number();
    $province   = $this->mysql->db_escape($this->address->get_province());
    $city       = $this->mysql->db_escape($this->address->get_city());
    $street     = $this->mysql->db_escape($this->address->get_street());
    $last_name  = $this->mysql->db_escape($this->address->get_last_name());
    $first_name = $this->mysql->db_escape($this->address->get_first_name());

    if ( !isset($pupil_id) )
      die("Error: OMITTED VAR VALUE -> add_address() in file ". __file__ ." line ". __line__);
    if ( !($country_id==0 && $zip=="" && $city=="" && $street=="" && $house_no=="" && $first_name=="" && $last_name=="" && $province=="") )
    {
      $query = "INSERT INTO `Schueler_Adresse` (`SID`,       `Land_ID`,     `plz`,  `ort`,   `strasse`, `haus_Nr`,   `vorname`,     `nachname`,   `bundesland` )
                VALUES                         ('$pupil_id', '$country_id', '$zip', '$city', '$street', '$house_no', '$first_name', '$last_name', '$province');";
      $this->mysql->query($query);
      $address_id = $this->mysql->insertid();
      if ( $address_id > 0 )
      {
        $this->address->set_address_id($address_id);
        $this->pupil->set_address_id($address_id);
        $query = "UPDATE `Schueler` SET `Adress_ID` = '$address_id' WHERE `SID` = '$pupil_id'";
        $this->mysql->query($query);
        if ( is_array( $this->info_messages ) )
          $this->info_messages = array_merge( $this->info_messages, array( 'add_address' => "Pers&ouml;nliche Daten erfolgreich eingetragen!"));
        else
          $this->info_messages = array( 'add_address' => "Pers&ouml;nliche Daten erfolgreich eingetragen!" );
      }
      else
        die("Error: NO ADDRESS ID -> add_address() in file ". __file__ ." line ". __line__);
    }
  }
  /////////////////////////////////////////////////////////////////////////
  // TODO: create, return all error messages ( replace die() )
  public function get_error_messages()
  {
    return $this->error_messages;
  }
  /////////////////////////////////////////////////////////////////////////
  // returns all info messages
  public function get_info_messages()
  {
    return $this->info_messages;
  }
}














?>