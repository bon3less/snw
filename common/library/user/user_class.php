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
require_once 'user_interface.php';
class User implements IUser
{
    private $user_id;
    private $user_login;    // unique identity
    private $user_password;
    private $online_status;
    private $anmelde_datum; // account creation
    private $activated;
    private $session;
    protected $access;
    private static $mysql;
    const USER = 'USER';

    function __construct($param_arr = null)
    {
      // set member vars
      if ( is_array($param_arr) )
      {
        $this->user_login     = @$param_arr['acc_id'];
        $this->user_password  = @$param_arr['password'];
      }
      else
        die('Error: No logon information found, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
    }

    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set user id
    public function get_user_id()
    {
      return $this->user_id;
    }

    public function set_user_id($user_id)
    {
      $this->user_id=$user_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set user login
    public function get_user_login()
    {
      return $this->user_login;
    }
    
    public function set_user_login($user_login)
    {
      $this->user_login=$user_login;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set user password
    public function get_user_password()
    {
      return $this->user_password;
    }
    
    public function set_user_password($user_password)
    {
      $this->user_password=$user_password;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set online status
    public function get_online_status()
    {
      return $this->online_status;
    }
    
    public function set_online_status($online_status)
    {
      $this->online_status=$online_status;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set anmelde datum
    public function get_anmelde_datum()
    { 
      if ( (!(@isset($this->anmelde_datum)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        $query = "SELECT `anmelde_Datum`
                  FROM   `Schueler_Login`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $anmelde_datum = $this->mysql->get_result_field();
        if ( strlen($anmelde_datum) > 0)
        {     
          $this->anmelde_datum = $anmelde_datum;
        }
        else 
          die ('Error: Account creation date is empty, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      }
      return $this->anmelde_datum;
    }
    
    public function set_anmelde_datum($anmelde_datum)
    {
      $this->anmelde_datum=$anmelde_datum;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set activated
    public function get_activated()
    {
      return $this->activated;
    }

    public function set_activated($activated)
    {
      $this->activated=$activated;
    }

    /*------------------------------------------------------------------------*/
    // LOGIN
    public function login()
    {
      if ( !($this->user_id > 0) )
        return false;


      // register session vars
      $user_name = $this->user_login;
      $uid       = $this->user_id;
      // start a new session
      $this->session = Session_manager::singleton($uid);
      session_register("this_user");
      session_register("this_user_id");
      $_SESSION['this_user']    = $user_name;
      $_SESSION['this_user_id'] = $uid;
      session_register("user_obj");
      if ( !($this->session->get_uid() > 0) )
        $this->session->set_uid($uid);
      $this->session->write_vars();

      return $this->session;
    }
    /*------------------------------------------------------------------------*/
    // TODO: LOGOUT
    public function logout()
    {
      if ( !(isset($this->session)) )
        return false;
      $uid       = $this->user_id;
      $this->session->set_uid($uid);
      $this->session->clean_up();
      $this->session->destroy_session();
      $this->session = null;
      $result_unregister = session_unregister("this_user");
      $result_destoy     = session_destroy();
      if ($result_unregister && $result_destoy)
      {
        // log out succeeded
        return true;
      }
      else
      {
        // user can't be logged out -> check why
        return false;
      }
    }
}

?>