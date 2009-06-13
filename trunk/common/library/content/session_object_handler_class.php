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
 * class Session_object_handler (static)
 * 
 * creates objects as session vars 
 *
 *******************************************************************************/
  class Session_object_handler
  {
    // selection
    static function add_object($obj_name = "", $param = "")
    {
      if (strlen($obj_name) > 0)
      {
        switch($obj_name)
        {
          case 'user_obj':      $user = new User($param);
                                Session_object_handler::_add_object($obj_name, $user);
                                break;
          case 'curriculum':    $curriculum = new Curriculum();
                                Session_object_handler::_add_object($obj_name, $curriculum);
                                break;
          case 'grade':         $grade = new Grade_of_school($param);
                                Session_object_handler::_add_object($obj_name, $grade);
                                break;
          case 'friend':        $friend = new Friend($param);
                                Session_object_handler::_add_object($obj_name, $friend);
                                break;
          case 'pupil':         $pupil = new Pupil($param);
                                Session_object_handler::_add_object($obj_name, $pupil);
                                break;
          case 'pupil_address': $pupil_address = new Address_pupil($param);
                                Session_object_handler::_add_object($obj_name, $pupil_address);
                                break;
          case 'school':        $school = new School($param);
                                Session_object_handler::_add_object($obj_name, $school);
                                break;
          case 'teacher':       $teacher = new Teacher();
                                Session_object_handler::_add_object($obj_name, $teacher);
                                break;
          default:              return false;
                                break;
        }
      }
      return false;
    }   
    //
    private function _add_object($obj_name = "", $obj = null)
    {
      if ( isset($_SESSION) && is_array($_SESSION) &&  (strlen($obj_name) > 0) && isset($obj) )
      {
        $_SESSION["$obj_name"] = $obj;
        return true;
      }
      return false;
    }
    //
    static function del_object($obj_name = "")
    {
      if ( isset($_SESSION) && is_array($_SESSION) &&  (strlen($obj_name) > 0) )
      {
        $_SESSION["$obj_name"] = "";
        return true;
      }
      return false;
    }   
  }
?>