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
  
  class Grade_of_school
  {
    private $grade_id;
    private $school_id;
    private $pupil_id;
    private $teacher_id;
    private $grade_name;
    private $grade;

    // constructor
    function __construct($param_arr)
    {
      if ( is_array($param_arr) )
      {
        $this->grade_name = $param_arr['grade_name'];
      }
      elseif ( (isset($param_arr)) && (is_numeric($param_arr)) )
      {
        // param_arr should contain the grade_id
        $this->grade_id = $param_arr;
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // set pupil_address properties via database query
        $query = "SELECT * FROM `Klassen` WHERE `Klassen_ID` = '$this->grade_id'";
        $this->mysql->query($query);
        $result = @$this->mysql->get_result_array();        
        // set member variables
        list($grade_arr) = $result; // gets the first dimension
        $this->school_id   = @$grade_arr['Schul_ID'];
        $this->teacher_id  = @$grade_arr['LID'];
        $this->grade_name  = @$grade_arr['klassen_Name'];
        $this->grade       = @$grade_arr['klassen_Stufe'];
      }
      else
      {
        die('Error: Cannot create grade object, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      }
    }
    
    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set grade id
    public function get_grade_id()
    {
      return $this->grade_id;
    }
    
    public function set_grade_id($grade_id)
    {
      $this->grade_id=$grade_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school id
    public function get_school_id()
    {
      return $this->school_id;
    }
    
    public function set_school_id($school_id)
    {
      $this->school_id=$school_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set pupil ID
    public function get_pupil_id()
    {
      return $this->pupil_id;
    }
    
    public function set_pupil_id($pupil_id)
    {
      $this->pupil_id=$pupil_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set teacher id
    public function get_teacher_id()
    {
      return $this->teacher_id;
    }
    
    public function set_teacher_id($teacher_id)
    {
      $this->teacher_id=$teacher_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set grade name
    public function get_grade_name()
    {
      return $this->grade_name;
    }
    
    public function set_grade_name($grade_name)
    {
      $this->grade_name=$grade_name;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set grade
    public function get_grade()
    {
      return $this->grade;
    }
    
    public function set_grade($grade)
    {
      $this->grade=$grade;
    }//*/
    
  }
