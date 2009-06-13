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
  
  class Curriculums
  {
    private $curriculum_ids;
    private $curriculum_names;
    private $teacher_id;
  
    // constructor
    function __construct()
    {
      
    }
    
    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set curriculum IDs[] (Array)
    public function get_curriculum_ids()
    {
      return $this->curriculum_ids;
    }
    
    public function set_curriculum_ids($curriculum_ids)
    {
      $this->curriculum_ids=$curriculum_ids;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set curriculum names[] (Array)
    public function get_curriculum_names()
    {
      return $this->curriculum_names;
    }
    
    public function set_curriculum_names($curriculum_names)
    {
      $this->curriculum_names=$curriculum_names;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set teacher ID
    public function get_teacher_id()
    {
      return $this->teacher_id;
    }
    
    public function set_teacher_id($teacher_id)
    {
      $this->teacher_id=$teacher_id;
    }
    
  }