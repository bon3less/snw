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
 * class Spam_blocker
 *
 * returns TRUE if spam was detected, otherwise FALSE
 *
 */
  class Spam_blocker
  {
    const MIN_REQUEST_INTERVAL = 3;   // minimum time in seconds for the next request per host
    const MAX_REQUEST_INTERVAL = 600; // maximum time in seconds for the next request per host
    const MAX_BAD_REQUESTS = 10;      // maximum amount of bad requests until the ip address will be blocked
    private $MAX_SESSION_LIFE_TIME; // the value from the SessionManager class
    private $ip;
    private $host;
    private $sess_id;
    private $sess_start;
    private static $mysql;
    /////////////////////////////////////////////////////////////////////////
    // constuctor / destructor
    public function __construct($max)
    {
      // set vars
      $this->MAX_SESSION_LIFE_TIME = $max;
      $this->ip = $_SERVER['REMOTE_ADDR'];
      $this->host = gethostbyaddr($this->ip);
      $this->sess_id = session_id();
      $this->sess_start = time();
      // create db connection instance
      $config_arr = Serialization::convert();
      $this->mysql = Mysql_Class::singleton($config_arr);
      // call member function to make the database log entry
      $this->first_request();
    }
    /*function __destruct()
    {}*/
    /////////////////////////////////////////////////////////////////////////
    // do db entry
    private function first_request()
    {
      $query = "SELECT `Sb_ID`
               FROM   `Spam_blocker`
               WHERE  `IP_addr`      = '$this->ip'
               AND    `session_id`   = '$this->sess_id'";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      if  ( isset($result) && $result > 0 )
      {
        return;
      }
      if ( isset($this->ip) && isset($this->sess_id) )
      {
        $query = "INSERT INTO `Spam_blocker` (`Sb_ID`, `IP_addr`,   `host_name`,   `session_id`,     `session_start`,     `last_request`)
                 VALUES                     ('',      '$this->ip', '$this->host', '$this->sess_id', '$this->sess_start', '$this->sess_start');";
        $this->mysql->query($query);
      }
      else
        die("Error: first_request() in line ". __line__ . " file " . __file__ );
    }
    /////////////////////////////////////////////////////////////////////////
    // update last request time
    private function write_last_request()
    {
      $time = time();
      $query = "UPDATE `Spam_blocker`
               SET    `last_request` = '$time'
               WHERE  `IP_addr`      = '$this->ip'
               AND    `session_id`   = '$this->sess_id';";
      $this->mysql->query($query);
    }
    /////////////////////////////////////////////////////////////////////////
    // check if the request is valid
    public function check_request()
    {
      $result = false;
      // check if the IP address is already blocked
      $query = "SELECT `Sb_ID`
               FROM   `Spam_blocker`
               WHERE  `IP_addr`      = '$this->ip'
               AND    `blocked`      = 1
               AND    `session_id`   = '$this->sess_id';";  // for IP + SESSION BLOCK
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      if ( isset($result) && $result > 0 )
        return true;
      // check time interval between requests
      $time = time();
      $min_time = $time - self::MIN_REQUEST_INTERVAL;
      $query = "SELECT `Sb_ID`
               FROM   `Spam_blocker`
               WHERE  `IP_addr`      = '$this->ip'
               AND    `session_id`   = '$this->sess_id'
               AND    `last_request` >= '$min_time';";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      $this->write_last_request(); // updating last request time
      if ( $result )
      {
        $got_block = $this->block_ip();
        if ( $got_block )
          return true;
      }
      return false;
    }
    /////////////////////////////////////////////////////////////////////////
    // blocks an ip address
    // TODO: count blocks of $this->ip, if num_rows gt 10 then block aswell
    private function block_ip()
    {
      // check counter
      $query = "SELECT `counter`
               FROM   `Spam_blocker`
               WHERE  `IP_addr`      = '$this->ip'
               AND    `session_id`   = '$this->sess_id';";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      if ( $result < self::MAX_BAD_REQUESTS  ) // counter++
      {
        $query = "UPDATE `Spam_blocker`
                 SET    `counter`     = `counter` + 1
                 WHERE  `IP_addr`     = '$this->ip'
                 AND    `session_id`  = '$this->sess_id';";  //TODO: TESTS
        $this->mysql->query($query);
        return false;
      }
      elseif ( !($result < self::MAX_BAD_REQUESTS)  ) // block ip_addr
      {
        $query = "UPDATE `Spam_blocker`
                 SET    `blocked`        = 1,
                        `session_start`  = 0,
                        `last_request`   = 0
                 WHERE  `IP_addr`        = '$this->ip'
                 AND    `session_id`     = '$this->sess_id';"; //TODO: TESTS
        $this->mysql->query($query);
        $query = "UPDATE `Schueler_Login`
                 SET    `session_id`          = 0,
                        `session_start_time`  = 0,
                        `session_vars`        = '',
                        `online_Status`       = 0,
                        `flag`                = 0
                 WHERE  `session_id`          = '$this->sess_id';";
        $this->mysql->query($query);
        return true;
      }
      else
        die("Error: block_ip() in line ". __line__ . " file " . __file__ );
    }
    /////////////////////////////////////////////////////////////////////////
    // clean up old db entries (all who were not blocked)
    public function clean_up()
    {
      $max_time = self::MAX_SESSION_LIFE_TIME;
      $del_time = time() - $max_time;
      $session = new Session_manager();
      $session_time = $session->get_session_time();
      if ( $session_time >= $max_time )
      { echo "TEST <br />";
        $query = "DELETE FROM `Spam_blocker`
                 WHERE       `blocked` = 0
                 AND         `session_start_` < '$del_time';";
        $this->mysql->query($query);
        $result = $this->mysql->get_result();
        return (bool)$result;
      }
    }

  }