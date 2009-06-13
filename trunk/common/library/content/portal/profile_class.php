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

/**
 * Class Profile: generates an profile
 *
 */
class Profile
{
  private $user;
  private $school;
  private $grade;
  private $address;
  private $pupil;
  private $session;
  private $error_messages = "";   // infos for the admin
  private $info_messages  = "";   // infos for the user
  private static $mysql;

  public function __construct($session_arr, $session)
  {
    // set objects vars
    $this->session = $session;
    $this->user    = $session_arr['user_obj'];
    $this->school  = $session_arr['school'];
    $this->grade   = $session_arr['grade'];
    $this->address = $session_arr['address'];
    $this->pupil   = $session_arr['pupil'];
    // create db connection instance
    $config_arr = Serialization::convert();
    $this->mysql = Mysql_Class::singleton($config_arr);
  }

  /*------------------------------------------------------------------*/

  /**
   * Description: returns the template array for the profile.
   *
   * @return array
   */
  public function get_profile()
  {
    // align the content with the current session vars
    if ( isset($this->session) && is_object($this->session) )
    {
      // get objects via session
      $school = $this->school;
      $grade = $this->grade;
      $user  = $this->user;
      $pupil = $this->pupil;
      // nickname
      $nick = $pupil->get_nick_name();
      // online time
      $session_time = $this->session->get_session_time();
      $online_hours   = (date('G', $session_time)) - 1;
      $online_minutes = (int)date('i', $session_time );
      $h =$online_hours==1?chr(32):chr(110);
      $m =$online_minutes==1?chr(32):chr(110);
      if( $online_hours > 0 )
      $hour_string = "$online_hours Stunde$h und ";
      // kind of province name ('kanton' vs. 'bundesland')
      $country = $school->get_land_name();
      if ($country == "Schweiz")
        $province_name = "Kanton";
      else
        $province_name = "Bundesland";
      // fill the template array
      $profile = array (  ///////////////PUPIL//////////////
      //"CONTENT_LEFT"      => "./common/templates/profile_view.tpl", // for css setup only
      //"CONTENT_RIGHT"     => "./common/templates/profile_view.tpl", // for css setup only
                          "USER_NICK"         => "$nick",
                          "ONLINE_STATUS"     => "Online seit ". $hour_string ."$online_minutes Minute". $m,
                          "MEMBER_SINCE"      => date('r', $user->get_anmelde_datum()),
                          "PUPIL_EMAIL"       => $pupil->get_email(),
                          "PUPIL_CELL"        => $pupil->get_mobile_no(),
                          "PUPIL_SKYPE"       => $pupil->get_skype_no(),
                          "PUPIL_ICQ"         => $pupil->get_icq_no(),
                          "PUPIL_MSN"         => $pupil->get_msn_id(),
                          "PUPIL_YAHOO"       => $pupil->get_yahoo_id(),
                          "PUPIL_AIM"         => $pupil->get_aim_id(),
                          "PUPIL_AGE"         => $pupil->get_age(),
                          "PUPIL_BIRTH"       => $pupil->get_birthdate(),
                          "PUPIL_GENDER"      => $pupil->get_gender(),
                          "PUPIL_PROFILE_URL" => "#",
      ///////////////SCHOOL/////////////
                          "SCHOOL_COUNTRY"    => $country,
                          "SCHOOL_CITY"       => $school->get_school_ort(),
                          "KANTON_KIND"       => $province_name,
                          "SCHOOL_BUNDESLAND" => $school->get_school_kanton(),
                          "SCHOOL_NAME"       => $school->get_school_ort(),
                          "GRADE_NAME"        => $grade->get_grade_name(),
      ///////////////NAMES//////////////
                          "ADD_FRIEND"        => "'$nick"." als Freund hinzuf&uuml;gen'",  // only for public profile
                          "PROFILE_IMG"       => "'$nick"."s Profilbild'",
                          "SEND_MSG"          => "'$nick"."eine Nachricht senden'",
                          "FRIEND_LIST"       => "'$nick"."s Freunde'",
                          "CLASS_MATES"       => "'$nick"."s Klassenkameraden'",
                          "VOTE_LIST"         => "'$nick"."s Bewertungen'",
                          "FAVORITE_LIST"     => "'$nick"."s Favoriten'",
                          "PICTURE_LIST"      => "'$nick"."s Bilder'",
      ///////////////LINKS//////////////
                          "_SEND_MSG"         => '"cat.php?cat=1&amp;topic=21"',
                          "_PROFILE_IMG"      => '"common/img/upload/profile/test'. $user->get_user_id() .'.jpg"', // TODO: load from DB
                          "_ADD_FRIEND"       => '"cat.php?cat=1&amp;topic=22"',
                          "_FRIEND_LIST"      => '"cat.php?cat=1&amp;topic=23"',
                          "_CLASS_MATES"      => '"cat.php?cat=1&amp;topic=24"',
                          "_VOTE_LIST"        => '"cat.php?cat=1&amp;topic=25"',
                          "_FAVORITE_LIST"    => '"cat.php?cat=1&amp;topic=26"',
                          "_PICTURE_LIST"     => '"cat.php?cat=1&amp;topic=27"',
                          ""                  => ""
                          );
                          return $profile;
    }
    return false;
  }

  public function edit_profile()
  {
    //
  }

}
?>