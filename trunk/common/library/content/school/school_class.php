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
  class School
  {
    private $schul_id;
    private $schul_name;
    private $land_id;
    private $land_name;
    private $school_plz;
    private $school_ort;
    private $school_kanton;
    private $school_url;
    private $school_strasse;
    private $school_str_nr;
    private $approved;
  
    // constructor
    function __construct($param_arr)
    {
      if ( is_array($param_arr) )
      {
        $this->schul_name     = $param_arr['school_name'];
        $this->land_id        = $param_arr['school_country'];
        $this->school_plz     = $param_arr['school_zip_code'];
        $this->school_ort     = $param_arr['school_city'];
        $this->school_kanton  = $param_arr['school_province'];
        $this->school_url     = $param_arr['school_url'];
        $this->school_strasse = $param_arr['school_street'];
        $this->school_str_nr  = $param_arr['school_house_number'];
      }
      elseif ( (isset($param_arr)) && (is_numeric($param_arr)) )
      {
        // param_arr should contain the schul_id
        $this->schul_id = $param_arr;
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // set pupil_address properties via database query
        $query = "SELECT * FROM `Schule` WHERE `Schul_ID` = '$this->schul_id'";
        $this->mysql->query($query);
        $result = @$this->mysql->get_result_array();        
        // set member variables
        list($school_arr)     = $result; // gets the first dimension
        $this->schul_name     = @$school_arr['Schul_Name'];
        $this->land_id        = @$school_arr['Land_ID'];
        $this->school_plz     = @$school_arr['plz'];
        $this->school_ort     = @$school_arr['ort'];
        $this->school_kanton  = @$school_arr['bundesland'];
        $this->school_strasse = @$school_arr['schul_Strasse'];
        $this->school_str_nr  = @$school_arr['schul_Strasse_Nr'];
        $this->school_url     = @$school_arr['home_Page'];
        $this->approved       = @$school_arr['approved'];
      }
      else
      {
        die('Error: Cannot create school object, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      }
    }

    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set school ID
    public function get_school_id()
    {
      return $this->schul_id;
    }
    
    public function set_school_id($schul_id)
    {
      $this->schul_id=$schul_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school name
    public function get_school_name()
    {
      return $this->schul_name;
    }
    
    public function set_school_name($schul_name)
    {
      $this->schul_name=$schul_name;
    }
    
        
    /*------------------------------------------------------------------------*/
    // get/set school land name
    public function get_land_name()
    {
      if ( strlen($this->land_name) > 0 )
        return $this->land_name;
      else
      {
        $this->set_land_name();
        return $this->land_name;
      }
    }
    
    public function set_land_name($land_name = null)
    {
      if ( strlen(trim($land_name)) > 0 )
        $this->land_name=$land_name;
      else
      {
        // create db connection instance
        $config_arr = Serialization::convert();
        $mysql = Mysql_Class::singleton($config_arr);
        $mysql->query("SELECT `land_Name` FROM `Laender` WHERE `Land_ID` = '$this->land_id'");
        $land_name = $mysql->get_result_field();
        if ( strlen($land_name) > 0 )
          $this->land_name=$land_name;
        else
          die('Error: Unable to query country name, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      }
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school land ID
    public function get_land_id()
    {
      return $this->land_id;
    }

    private function set_land_id($land_id)
    {
      $this->land_id=$land_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school plz
    public function get_school_plz()
    {
      return $this->school_plz;
    }
    
    public function set_school_plz($plz)
    {
      $this->school_plz=$plz;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school bindesland
    public function get_school_kanton()
    {
      return $this->school_kanton;
    }
    
    public function set_school_kanton($school_kanton)
    {
      $this->school_kanton=$school_kanton;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school ort
    public function get_school_ort()
    {
      return $this->school_ort;
    }
    
    public function set_school_ort($ort)
    {
      $this->school_ort=$ort;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school street
    public function get_school_strasse()
    {
      return $this->school_strasse;
    }
    
    public function set_school_strasse($school_strasse)
    {
      $this->school_strasse=$school_strasse;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school house number
    public function get_school_str_nr()
    {
      return $this->school_str_nr;
    }

    public function set_school_str_nr($school_str_nr)
    {
      $this->school_str_nr=$school_str_nr;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school URL
    public function get_school_url()
    {
      return $this->school_url;
    }
    
    public function set_school_url($url)
    {
      $this->school_url=$url;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school is approved
    public function get_approved()
    {
      return $this->approved;
    }
    
    public function set_approved($status)
    {
      $this->approved=$status;
    }
  }
?>