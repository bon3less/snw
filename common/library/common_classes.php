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
 * class Redirection 
 *****************************************************************************/
  class Redirection
  {
    /////////////////////////////////////////////////////////////////////////
    // redirects to the specific url
    static function redirect($url) 
    {
      header("Location: ".$url);
    }
    /////////////////////////////////////////////////////////////////////////
    // reloads the page via header to the current URL
    static function reload() 
    {
      $url = Redirection::get_full_url();
      header("Location: $url");
    }
    /////////////////////////////////////////////////////////////////////////
    // performs an real redirection (this one is not that conform but works well)
    static function meta_redirect($url, $target = "TODO")  //   TODO: target='".$target."'
    {
      $doc = new DOMDocument();
      $doc->loadHTML("<meta http-equiv='refresh' content='0; URL=".$url."' />");
      echo $doc->saveHTML();
      echo "                          <div class='redirect'>\n";
      echo "                            <p>\n";
      echo "                              Dein Browser unterst&uuml; keine Weiterleitung...?<br />\n";
      echo "                              Klicke <a class='context' href='".$url."'>here</a>,&nbsp; um direkt weitergeleitet zu werden.<br /><br />\n";
      echo "                            </p>\n";
      echo "                          </div>\n";
    }
    /////////////////////////////////////////////////////////////////////////
    // returns a full URL string (including the query string)
    static function get_full_url()
    {
      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
      $domain   = $_SERVER['HTTP_HOST'];
      $url  = $_SERVER['REQUEST_URI'];
      $link = $protocol.$domain.$url;
      return $link;
    }
    /////////////////////////////////////////////////////////////////////////
    //returns a base url string (without script name)
    static function get_base_url()
    {
      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
      $path = pathinfo($_SERVER['SCRIPT_NAME']);
      $url  = $protocol.$_SERVER['HTTP_HOST'].$path['dirname'];
      if(substr($url,-1) != "/")
        $url .= "/";
      return $url;
    }
  }
  
/******************************************************************************
 * class Converter 
 *****************************************************************************/
  class Converter
  {
    //
    
  }

/******************************************************************************
 * class Split_array
 *****************************************************************************/
  class Split_array
  {
    static function to_param_arr_user($param_array)
    {
      $param_arr_user   = array(  'acc_id'                  => @$param_array['acc_id']);
      if ( isset($param_array['password']) )
        $param_arr_user = array_merge (                     
          $param_arr_user, array( 'password'                => @$param_array['password']));
      if ( isset($param_array['acc_passwd']) )
        $param_arr_user = array_merge (                     
          $param_arr_user, array( 'password'                => @$param_array['acc_passwd']));
      if ( isset($param_array['password_check']) )          
        $param_arr_user = array_merge (                     
          $param_arr_user, array( 'password_check'          => @$param_array['password_check']));
      return $param_arr_user;                               
    }                                                       
    static function to_param_arr_school($param_array)       
    {
      if ( $param_array['school_zip_code']     == "Postleitzahl" )
        $param_array['school_zip_code']         = "";
      if ( $param_array['school_house_number'] == "Nr." )
        $param_array['school_house_number']     = "";
      if ( $param_array['school_url']          == "http://" 
      || ( $param_array['school_url']          == "Webseite") )
        $param_array['school_url']              = "";
      $param_arr_school = array(  'school_name'             => @$param_array['school_name'],
                                  'school_country'          => @$param_array['country_school'],
                                  'school_province'         => @$param_array['school_province'],
                                  'school_zip_code'         => @$param_array['school_zip_code'],
                                  'school_street'           => @$param_array['school_street'],
                                  'school_house_number'     => @$param_array['school_house_number'],
                                  'school_city'             => @$param_array['school_city'],
                                  'school_url'              => @$param_array['school_url']);
      return $param_arr_school;
    }
    static function to_param_arr_grade($param_array)        
    {                                                       
      $param_arr_grade  = array(  'grade_name'              => @$param_array['grade_name']);
      return $param_arr_grade;                              
    }                                                       
    static function to_param_arr_pupil($param_array)
    {
      if ( $param_array['age']           == "Alter" )
        $param_array['age']               = "";
      if ( $param_array['birth_date']    == "Geburtstag" )
        $param_array['birth_date']        = "";
      if ( $param_array['cell_phone_no'] == "Handy-Nummer" )
        $param_array['cell_phone_no']     = "";
      if ( $param_array['skype_no']      == "Skype-Nummer" )
        $param_array['skype_no']          = "";
      if ( $param_array['icq_no']        == "ICQ Nummer" )
        $param_array['icq_no']            = "";
      if ( $param_array['msn_id']        == "MSN Messenger" )
        $param_array['msn_id']            = "";
      if ( $param_array['yahoo_id']      == "Yahoo Messenger" )
        $param_array['yahoo_id']          = "";
      if ( $param_array['aim_id']        == "AIM Messenger" )
        $param_array['aim_id']            = "";
      if ( $param_array['about_me']      == "Hier kannst du dich kurz beschreiben..." )
        $param_array['about_me']          = "";
      $param_arr_pupil  = array(  'nickname'                => @$param_array['nickname'],
                                  'e-mail'                  => @$param_array['e-mail'],
                                  'age'                     => @$param_array['age'],
                                  'birth_date'              => @$param_array['birth_date'],
                                  'gender'                  => @$param_array['you_are'],
                                  'newsletter'              => @$param_array['newsletter'],
                                  'cell_phone_no'           => @$param_array['cell_phone_no'],
                                  'skype_no'                => @$param_array['skype_no'],
                                  'icq_no'                  => @$param_array['icq_no'],
                                  'msn_id'                  => @$param_array['msn_id'],
                                  'yahoo_id'                => @$param_array['yahoo_id'],
                                  'aim_id'                  => @$param_array['aim_id'],
                                  'about_me'                => @$param_array['about_me']);
      return $param_arr_pupil;                              
    }                                                       
    static function to_param_arr_address($param_array)      
    {
      if ( $param_array['first_name']   == "Vorname" )
        $param_array['first_name']       = "";
      if ( $param_array['last_name']    == "Nachname" )
        $param_array['last_name']        = "";
      if ( $param_array['country']      == "NONE" )
        $param_array['country']          = "0";
      if ( ($param_array['province']    == "Bundesland")
      ||   ($param_array['province']    == "Kanton") )
        $param_array['province']         = "";
      if ( $param_array['street']       == "Stra".CHR(195).chr(159)."e" 
      ||   $param_array['street']       == "Stra&szlig;e" )
        $param_array['street']           = "";
      if ( $param_array['house_number'] == "Nr." )
        $param_array['house_number']     = "";
      if ( $param_array['city']         == "Wohnort" )
        $param_array['city']             = "";
      if ( $param_array['zip_code']     == "Postleitzahl" )
        $param_array['zip_code']         = "";
      $param_arr_address = array( 'first_name'              => @$param_array['first_name'],
                                  'last_name'               => @$param_array['last_name'],
                                  'country'                 => @$param_array['country'],
                                  'province'                => @$param_array['province'],
                                  'street'                  => @$param_array['street'],
                                  'house_number'            => @$param_array['house_number'],
                                  'city'                    => @$param_array['city'],
                                  'zip_code'                => @$param_array['zip_code']);
      return $param_arr_address;
    }

  }
   

  
?>