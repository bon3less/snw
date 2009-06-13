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

 /*******************************************************************************
 * class Session_Manager
 *******************************************************************************/
  class Session_manager
  {
    const MAX_SESSION_LIFE_TIME = 10800; // default: 10800 in seconds ( minimum 60 seconds )
    private $session;
    private $sess_id;
    private $session_start_time;
    private $session_vars;
    private $uid;
    private static $mysql;
    private static $session_manager;
    /////////////////////////////////////////////////////////////////////////
    // constructor
    private function __construct( $uid = 0)
    {
      // set locals
      $this->uid = $uid;
      // session configurations
      session_name("sid");
      session_cache_expire(self::MAX_SESSION_LIFE_TIME/60);
      ini_set('session.cookie_domain', '');
      ini_set('session.use_cookies', '1');
      ini_set('session.use_only_cookies', '1');
      ini_set('session.use_trans', '0');
      ini_set('session.auto_start', '0');
      if ($uid == 0)  // Anonymous user
      {
        // start session
        if(!session_id())
        	$this->session = session_start();
      }
      elseif ( $uid > 0 ) // Registered user
      {
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // start session
        $this->session = null;
        $this->session = session_start();
        // create db entries
        $this->check_sid();
        $this->set_session_start_time();
        $this->clean_up();

      }
      else
        die('Error: uid = null in '. __file__ .' line '. __line__ .'.');
      // check for session corruption
      if ( (isset($HTTP_SESSION_VARS)) && !(is_array($HTTP_SESSION_VARS))
      ||   (isset($_SESSION))          && !(is_array($_SESSION)) )
      {
        die("Error: Session in ". __file__ ."". __line__ .".");
      }
    }
    /////////////////////////////////////////////////////////////////////////
    // singlton function returns object User_validator
    public static function singleton($uid = 0)
    {
      if (!isset(self::$session_manager))
      {
        self::$session_manager = new Session_manager($uid);
      }
      return self::$session_manager;
    }
    /////////////////////////////////////////////////////////////////////////
    // check if SID is already known for this user, if not update sid
    private function check_sid()
    {
      $uid = $this->uid;
      $time = time();
      $sess_id = session_id();
      $query = "SELECT `session_id` FROM `Schueler_Login`
                WHERE  `session_id` = '$sess_id'
                AND    `User_ID`    = '$uid';";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      if ( !($result == $sess_id) )
      {
        $query = "UPDATE  `Schueler_Login`
                  SET     `session_id`          = '$sess_id',
                          `session_start_time`  = '$time',
                          `online_Status`       = 1,
                          `flag`                = 0
                  WHERE   `User_ID`             = '$uid';";
      }
      else
      {
        $query = "UPDATE  `Schueler_Login`
                  SET     `online_Status`       = 1,
                          `flag`                = 1
                  WHERE   `session_id`          = '$sess_id'
                  AND     `User_ID`             = '$uid';";
      }
      $this->mysql->query($query);
    }
    /////////////////////////////////////////////////////////////////////////
    // returns the session duration
    public function get_uid()
    {
      return $this->uid;
    }
    /////////////////////////////////////////////////////////////////////////
    // returns the session duration
    public function set_uid($uid)
    {
      if ( is_numeric($uid) && $uid > 0 )
      {
        $this->uid = $uid;
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // start session
        $this->session = null;
        $this->session = session_start();
        // create db entries
        $this->check_sid();
        $this->set_session_start_time();
        $this->clean_up();
        return true;
      }
      return false;
    }
    /////////////////////////////////////////////////////////////////////////
    // returns the session duration
    public function get_session_time()
    {
      $session_time = time() - $this->session_start_time;
      if (!$this->session_start_time)
        return false;
      return $session_time;
    }
    /////////////////////////////////////////////////////////////////////////
    // returns the session start time
    public function set_session_start_time()
    {
      $uid = $this->uid;
      $time = time();
      $sess_id = session_id();
      $query = "SELECT `session_start_time`
                FROM   `Schueler_Login`
                WHERE  `session_id` = '$sess_id'
                AND    `User_ID`    = '$uid';";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      $this->session_start_time = $result;
    }
    /////////////////////////////////////////////////////////////////////////
    // returns the maximum time value of a sessions lifetime
    public function get_max_session_life_time()
    {
      return self::MAX_SESSION_LIFE_TIME;
    }
    /////////////////////////////////////////////////////////////////////////
    // write session variables for the user to the database
    public function write_vars()
    {
      if (is_array($_SESSION))
      {
      $uid = $this->uid;
      $vars = Serialization::encode(serialize($_SESSION));
      $sess_id = session_id();
      $query = "UPDATE `Schueler_Login`
                SET    `session_vars` = '$vars'
                WHERE  `session_id`  = '$sess_id'
                AND    `User_ID`     = '$uid';";

      $this->mysql->query($query);
      return $this->mysql->get_result();
     }
     else
      return false;
    }
    /////////////////////////////////////////////////////////////////////////
    // reads session variables from the database
    public function read_vars()
    {
      $uid = $this->uid;
      $sess_id = session_id();
      $query = "SELECT `session_vars`
                FROM   `Schueler_Login`
                WHERE  `session_id`     ='$sess_id'
                AND    `User_ID`        = '$uid';";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      if (!$result)
        return false;
      $vars = array();
      $vars = unserialize(Serialization::decode($result));
      return $vars;
    }
    /////////////////////////////////////////////////////////////////////////
    // clean up old db entries (all)
    public function clean_up()
    {
      $session_time = $this->get_session_time();
      $max_time = self::MAX_SESSION_LIFE_TIME;
      $del_time = time() - $max_time;
      //echo $session_time."<br />";
      //echo $max_time."<br />";
      //echo $del_time."<br />";
      if ( $session_time >= $max_time )
      {
        $query = "UPDATE `Schueler_Login`
                  SET    `session_id`          = 0,
                         `session_start_time`  = 0,
                         `session_vars`        = null,
                         `online_Status`       = 0,
                         `flag`                = 0
                  WHERE  `session_start_time` <= '$del_time'
                  AND    `session_start_time` != 0;";
        $this->mysql->query($query);
        $result = $this->mysql->get_result();
        $this->destroy_session();
        return (bool)$result;
      }
    }
    /////////////////////////////////////////////////////////////////////////
    // when the user logs off the session should be destroyed
    // TODO: log off
    public function destroy_session()
    {
      $result = false;
      if (isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-42000, '/');
      if ( is_object($this->mysql) )
      {
        $uid = $this->uid;
        $sess_id = session_id();
        $query = "UPDATE `Schueler_Login`
                  SET    `session_id`          = 0,
                         `session_start_time`  = 0,
                         `session_vars`        = null,
                         `online_Status`       = 0,
                         `flag`                = 0
                  WHERE  `session_id`          = '$sess_id'
                  AND    `User_ID`             = '$uid';";
        $this->mysql->query($query);
        $this->session = null;
        $result = $this->mysql->get_result();
        return (bool)$result;
      }
      return $result;
    }
  }

?>