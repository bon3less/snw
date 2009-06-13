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
 * class User_validator 
 *****************************************************************************/
  class User_validator
  {
    private $user;
    private $info_messages;
    private $error_messages;
    private static $mysql;
    private static $user_validator; // singlton    
    /////////////////////////////////////////////////////////////////////////
    // constuctor
    private function __construct($user)
    {
      if (!isset($user))
        die('Error: No user object found! in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      $this->user = $user;
      // get db connection instance
      $config_arr = Serialization::convert();
      $this->mysql = Mysql_Class::singleton($config_arr);
    }
    /////////////////////////////////////////////////////////////////////////
    // singlton function returns object User_validator
    public static function singleton($user)
    {
      if (!isset(self::$user_validator))
      {
        self::$user_validator = new User_validator($user);
      }
      return self::$user_validator;
    }
    /////////////////////////////////////////////////////////////////////////
    // checks if a login is valid or not
    public function check_login()
    {
      $user_login  = $this->user->get_user_login();
      $user_passwd = $this->user->get_user_password();
      if ( !isset($user_login) || !isset($user_passwd) )
        die('Error: No logon information found, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      $user_login = md5(Serialization::encode($user_login));
      $user_passwd = md5(Serialization::encode($user_passwd));
      $query = "SELECT  `User_id` 
                FROM    `Schueler_Login` 
                WHERE   `user_Login`    = '$user_login'
                AND     `password`      = '$user_passwd';";
      $this->mysql->query($query);
      $user_id  = $this->mysql->get_result_field();
      $num_rows = $this->mysql->get_num_rows();
      if ( ($user_id > 0) && ($num_rows == 1) )
      {     
        $this->user->set_user_id($user_id);
        return true;
      }
      else
        return false;
    }
  }
?>
