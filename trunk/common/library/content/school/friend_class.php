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
  
  class Friend extends Pupil
  {
    private $friend_id;
    private $pupil_id;
    private $friends_pupil_id;
    private $friend_nick;
  
    // constructor
    function __construct($param_arr = null)
    {
      
    }
    
    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set freund id
    public function get_friend_id()
    {
      return $this->friend_id;
    }
    
    public function set_friend_id($friend_id)
    {
      $this->friend_id=$friend_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set pupil id
    public function get_pupil_id()
    {
      return $this->pupil_id;
    }
    
    public function set_pupil_id($pupil_id)
    {
      $this->pupil_id=parent::get_pupil_id();
    }//*/
    
    /*------------------------------------------------------------------------*/
    // get/set friends pupil id
    public function get_friends_pupil_id()
    {
      return $this->friends_pupil_id;
    }
    
    public function set_friends_pupil_id($friends_pupil_id)
    {
      $this->friends_pupil_id=$friends_pupil_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set friend nick name
    public function get_friend_nick()
    {
      return parent::get_nick_name();
    }
    
    public function set_friend_nick($friend_nick)
    {
      $this->friend_nick=parent::get_nick_name();
    }
    
    
  }
  