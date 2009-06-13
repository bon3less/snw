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
  
  class Address_pupil
  {
    private $address_id;
    private $pupil_id;
    private $first_name;
    private $last_name;
    private $country_id;
    private $province;
    private $street;
    private $house_number;
    private $zip_code;
    private $city;
    private static $mysql;
  
    // constructor
    function __construct($param_arr)
    {
      if ( is_array($param_arr) )
      {
        $this->first_name   = @$param_arr['first_name'];
        $this->last_name    = @$param_arr['last_name'];
        $this->country_id   = @$param_arr['country'];
        $this->province     = @$param_arr['province'];
        $this->street       = @$param_arr['street'];
        $this->house_number = @$param_arr['house_number'];
        $this->city         = @$param_arr['city'];
        $this->zip_code     = @$param_arr['zip_code'];
      }
      elseif ( (isset($param_arr)) && (is_numeric($param_arr)) )
      {
        // param_arr should contain the address_id
        $this->address_id = $param_arr;
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // set pupil_address properties via database query
        $query = "SELECT * FROM `Schueler_Adresse` WHERE `Adress_ID` = '$this->address_id'";
        $this->mysql->query($query);
        $result = @$this->mysql->get_result_array();        
        // set member variables
        list($address_arr)  = $result; // gets the first dimension
        $this->pupil_id     = @$address_arr['SID'];
        $this->first_name   = @$address_arr['vorname'];
        $this->last_name    = @$address_arr['nachname'];
        $this->country_id   = @$address_arr['Land_ID'];
        $this->province     = @$address_arr['bundesland'];
        $this->street       = @$address_arr['strasse'];
        $this->house_number = @$address_arr['haus_Nr'];
        $this->zip_code     = @$address_arr['plz'];
        $this->city         = @$address_arr['ort'];
      }
      else
      {
        die('Error: Cannot create pupils address object, in class'. __class__ .'. File '. __file__ .' in line '. __line__ .'.');
      }
    }
    
    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    
    /*------------------------------------------------------------------------*/
    // get/set address id
    public function get_address_id()
    {
      return $this->address_id();
    }
    
    public function set_address_id($address_id)
    {
      $this->address_id=$address_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set pupil id
    public function get_pupil_id()
    {
      return $this->pupil_id;
    }
    
    public function set_pupil_id($pupil_id)
    {
      $this->pupil_id=$pupil_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set first name
    public function get_first_name()
    {
      return $this->first_name;
    }
    
    public function set_first_name($first_name)
    {
      $this->first_name=$first_name;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set last name
    public function get_last_name()
    {
      return $this->last_name;
    }
    
    public function set_last_name($last_name)
    {
      $this->last_name=$last_name;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set country id
    public function get_country_id()
    {
      return $this->country_id;
    }
    
    public function set_country_id($country_id)
    {
      $this->country_id=$country_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set province
    public function get_province()
    {
      return $this->province;
    }
    
    public function set_province($province)
    {
      $this->province=$province;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set street
    public function get_street()
    {
      return $this->street;
    }
    
    public function set_street($street)
    {
      $this->street=$street;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set house_number
    public function get_house_number()
    {
      return $this->house_number;
    }
    
    public function set_house_number($house_number)
    {
      $this->house_number=$house_number;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set zip_code
    public function get_zip_code()
    {
      return $this->zip_code;
    }
    
    public function set_zip_code($zip_code)
    {
      $this->zip_code=$zip_code;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set city
    public function get_city()
    {
      return $this->city;
    }
    
    public function set_city($city)
    {
      $this->city=$city;
    }
  }