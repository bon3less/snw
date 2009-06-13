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
  
  class Teacher
  {
    private $teacher_id;
    private $pupil_id;
    private $grade_id;
    private $curriculum_ids;
    private $curriculum_names;
    private $school_id;
    private $teacher_name;
    private $gender;
  
    // constructor
    function __construct()
    {
      
    }
    
    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
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
    // get/set curriculum ID[] (Array)
    public function get_curriculum_ids()
    {
      return $this->curriculum_ids;
    }
    
    public function set_curriculum_ids($curriculum_ids)
    {
      $this->curriculum_ids=$curriculum_ids;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set curriculum NAMES[] (Array)
    public function get_curriculum_names()
    {
      return $this->curriculum_names;
    }
    
    public function set_curriculum_names($curriculum_names)
    {
        $this->curriculum_names=$curriculum_names;
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
    // get/set teacher name
    public function get_teacher_name()
    {
      return $this->teacher_name;
    }
    
    public function set_teacher_name($teacher_name)
    {
      $this->teacher_name=$teacher_name;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set grader
    public function get_gender()
    {
      return $this->gender;
    }
    
    public function set_gender($gender)
    {
      $this->gender=$gender;
    }
    
  }
