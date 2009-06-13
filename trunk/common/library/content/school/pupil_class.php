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
  require_once($snw_root .'common/library/user/user_class.php');
  class Pupil extends User
  {
    private $pupil_id;
    private $user_id;
    private $teacher_id;
    private $grade_id;
    private $address_id;
    private $school_id;
    private $nick_name;
    private $email;
    private $approval_status;
    private $age;
    private $birthdate;
    private $mobile_no;
    private $icq_no;
    private $msn_id;
    private $yahoo_id;
    private $aim_id;
    private $skype_no;
    private $newsletter_status;
    private $gender;
    private $profil_info;
    private static $mysql;
  
    // constructor
    function __construct($param_arr = null)
    {
      if ( is_array($param_arr) )
      {
        $this->nick_name          = @$param_arr['nickname'];
        $this->email              = @$param_arr['e-mail'];
        $this->age                = @$param_arr['age'];
        $this->birthdate          = @$param_arr['birth_date'];
        $this->gender             = @$param_arr['gender'];
        $this->newsletter_status  = @$param_arr['newsletter'];
        $this->mobile_no          = @$param_arr['cell_phone_no'];
        $this->skype_no           = @$param_arr['skype_no'];
        $this->icq_no             = @$param_arr['icq_no'];
        $this->msn_id             = @$param_arr['msn_id'];
        $this->yahoo_id           = @$param_arr['yahoo_id'];
        $this->aim_id             = @$param_arr['aim_id'];
        $this->profil_info        = @$param_arr['about_me'];
      }
      elseif ( (isset($param_arr)) && (is_numeric($param_arr)) )
      {
        // param_arr should contain the uid
        $user_id = $param_arr;
        $this->user_id = $user_id;
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
        // set pupil properties from database values at once
        $query = "SELECT * FROM `Schueler` WHERE `User_ID` = '$this->user_id'";
        $this->mysql->query($query);
        $result = @$this->mysql->get_result_array();        
        // set member variables
        list($pupil_arr) = $result; // gets the first dimension        
        $this->pupil_id          = @$pupil_arr['SID'];
        $this->teacher_id        = @$pupil_arr['LID'];
        $this->grade_id          = @$pupil_arr['Klassen_ID'];
        $this->address_id        = @$pupil_arr['Adress_ID'];
        $this->school_id         = @$pupil_arr['Schul_ID'];
        $this->nick_name         = @$pupil_arr['nick_Name'];
        $this->email             = @$pupil_arr['email'];
        $this->approval_status   = @$pupil_arr['status'];
        $this->birthdate         = @$pupil_arr['geburtstag'];
        $this->mobile_no         = @$pupil_arr['handy_Nr'];
        $this->icq_no            = @$pupil_arr['icq_Nr'];
        $this->skype_no          = @$pupil_arr['skype_Nr'];
        $this->msn_id            = @$pupil_arr['msn-id'];
        $this->yahoo_id          = @$pupil_arr['yahoo-id'];
        $this->aim_id            = @$pupil_arr['aim-id'];
        $this->profil_info       = @$pupil_arr['kontakt_Info'];
        $this->newsletter_status = @$pupil_arr['newsletter_Status'];
        $this->age               = @$pupil_arr['alter'];
        $this->gender            = @$pupil_arr['geschlecht'];               
      }
      else
      {
        // create db connection instance
        $config_arr = Serialization::convert();
        $this->mysql = Mysql_Class::singleton($config_arr);
      }
    }

    /************************************
    * GETTER AND SETTER METHODS
    ************************************/
    /*------------------------------------------------------------------------*/
    // get/set user id
    public function get_user_id()
    {
      return self::get_user_id();
      //return parent::get_user_id(); // TODO: get it from the parent class
    }
    
    public function set_user_id($user_id)
    {
      $this->user_id=$user_id;
      //$this->user_id=parent::set_user_id($user_id);  // TODO: set the parent class value
    }
     
    /*------------------------------------------------------------------------*/
    // get/set pupil id
    public function get_pupil_id()
    {
      return $this->pupil_id;
    }
    
    public function set_pupil_id($pupil_id = null)
    {
      if ( (!(@isset($this->pupil_id)) && !(isset($pupil_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->pupil_id > 0)    && !(isset($pupil_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `SID`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $pupil_id = $this->mysql->get_result_field();
        if ( $pupil_id > 0)
        {     
          $this->pupil_id=$pupil_id;
        }
      }
      elseif ( (isset($pupil_id)) && ($pupil_id > 0) )
        $this->pupil_id=$pupil_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set teacher id
    public function get_teacher_id()
    {
      return $this->teacher_id;
    }
    
    public function set_teacher_id($teacher_id = null)
    {
      if ( (!(@isset($this->teacher_id)) && !(isset($teacher_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->teacher_id > 0)    && !(isset($teacher_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `LID`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $teacher_id = $this->mysql->get_result_field();
        if ( $teacher_id > 0)
        {     
          $this->teacher_id=$teacher_id;
        }
      }
      elseif ( (isset($teacher_id)) && ($teacher_id > 0) )
        $this->teacher_id=$teacher_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set grade id
    public function get_grade_id()
    {
      return $this->grade_id;
    }
    
    public function set_grade_id($grade_id = null)
    {
      if ( (!(@isset($this->grade_id)) && !(isset($grade_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->grade_id > 0)    && !(isset($grade_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `Klassen_ID`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $grade_id = $this->mysql->get_result_field();
        if ( $grade_id > 0)
        {     
          $this->grade_id=$grade_id;
        }
      }
      elseif ( (isset($grade_id)) && ($grade_id > 0) )
        $this->grade_id=$grade_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set address id
    public function get_address_id()
    {
      return $this->address_id;
    }
    
    public function set_address_id($address_id = null)
    {
      if ( (!(@isset($this->address_id)) && !(isset($address_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->address_id > 0)    && !(isset($address_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `Adress_ID`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $address_id = $this->mysql->get_result_field();
        if ( $address_id > 0)
        {     
          $this->address_id=$address_id;
        }
      }
      elseif ( (isset($address_id)) && ($address_id > 0) )
        $this->address_id=$address_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set school id
    public function get_school_id()
    {
      return $this->school_id;
    }
    
    public function set_school_id($school_id = null)
    {
      if ( (!(@isset($this->school_id)) && !(isset($school_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->school_id > 0)    && !(isset($school_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `Schul_ID`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $school_id = $this->mysql->get_result_field();
        if ( $school_id > 0)
        {     
          $this->school_id=$school_id;
        }
      }
      elseif ( (isset($school_id)) && ($school_id > 0) )
        $this->school_id=$school_id;
    }

    /*------------------------------------------------------------------------*/
    // get/set nick name
    public function get_nick_name()
    {
      return $this->nick_name;
    }
    
    public function set_nick_name($nick_name = null)
    {
      if ( (!(@isset($this->nick_name))      && !(isset($nick_name)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->nick_name) > 0) && !(isset($nick_name)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `nick_Name`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $nick_name = $this->mysql->get_result_field();
        if ( strlen($nick_name) > 0)
        {     
          $this->nick_name=$nick_name;
        }
      }
      elseif ( (isset($nick_name)) && (strlen($nick_name) > 0) )
        $this->nick_name=$nick_name;
    }

    /*------------------------------------------------------------------------*/
    // get/set email
    public function get_email()
    {
      return $this->email;
    }
    
    public function set_email($email = null)
    {
      if ( (!(@isset($this->email))      && !(isset($email)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->email) > 0) && !(isset($email)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `email`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $email = $this->mysql->get_result_field();
        if ( strlen($email) > 0)
        {     
          $this->email=$email;
        }
      }
      elseif ( (isset($email)) && (strlen($email) > 0) )
      $this->email=$email;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set approval status
    public function get_approval_status()
    {
      return $this->approval_status;
    }
    
    public function set_approval_status($approval_status = null)
    {
      if ( (!(@isset($this->approval_status))      && !(isset($approval_status)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@is_numeric($this->approval_status)) && !(isset($approval_status)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `status`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $approval_status = $this->mysql->get_result_field();
        if ( is_numeric($approval_status) )
        {     
          $this->approval_status=$approval_status;
        }
      }
      elseif ( (isset($approval_status)) && (is_numeric($approval_status)) )
        $this->approval_status=$approval_status;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set birthdate
    public function get_birthdate()
    {
      return $this->birthdate;
    }
    
    public function set_birthdate($birthdate = null)
    {
      if ( (!(@isset($this->birthdate))      && !(isset($birthdate)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->birthdate) > 0) && !(isset($birthdate)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `geburtstag`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $birthdate = $this->mysql->get_result_field();
        if ( strlen($birthdate) > 0)
        {     
          $this->birthdate=$birthdate;
        }
      }
      elseif ( (isset($birthdate)) && (strlen($birthdate) > 0) )
        $this->birthdate=$birthdate;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set age
    public function get_age()
    {
      return $this->age;
    }
    
    public function set_age($age = null)
    {
      if ( (!(@isset($this->age)) && !(isset($age)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@$this->age > 0)    && !(isset($age)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `alter`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $age = $this->mysql->get_result_field();
        if ( $age > 0)
        {     
          $this->age=$age;
        }
      }
      elseif ( (isset($age)) && ($age > 0) )
        $this->age=$age;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set cell phone number (mobile)
    public function get_mobile_no()
    {
      return $this->mobile_no;
    }
    
    public function set_mobile_no($mobile_no = null)
    {
      if ( (!(@isset($this->mobile_no))      && !(isset($mobile_no)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->mobile_no) > 0) && !(isset($mobile_no)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `handy_Nr`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $mobile_no = $this->mysql->get_result_field();
        if ( strlen($mobile_no) > 0)
        {     
          $this->mobile_no=$mobile_no;
        }
      }
      elseif ( (isset($mobile_no)) && (strlen($mobile_no) > 0) )
        $this->mobile_no=$mobile_no;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set ICQ Messenger No.
    public function get_icq_no()
    {
      return $this->icq_no;
    }
    
    public function set_icq_no($icq_no = null)
    {
      if ( (!(@isset($this->icq_no))      && !(isset($icq_no)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->icq_no) > 0) && !(isset($icq_no)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `icq_Nr`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $icq_no = $this->mysql->get_result_field();
        if ( strlen($icq_no) > 0)
        {     
          $this->icq_no=$icq_no;
        }
      }
      elseif ( (isset($icq_no)) && (strlen($icq_no) > 0) )
        $this->icq_no=$icq_no;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set Skype (ip-phone) No.
    public function get_skype_no()
    {
      return $this->skype_no;
    }
    
    public function set_skype_no($skype_no = null)
    {
      if ( (!(@isset($this->skype_no))      && !(isset($skype_no)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->skype_no) > 0) && !(isset($skype_no)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `skype_Nr`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $skype_no = $this->mysql->get_result_field();
        if ( strlen($skype_no) > 0)
        {     
          $this->skype_no=$skype_no;
        }
      }
      elseif ( (isset($skype_no)) && (strlen($skype_no) > 0) )
        $this->skype_no=$skype_no;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set msn id (microsoft network messenger id).
    public function get_msn_id()
    {
      return $this->msn_id;
    }
    
    public function set_msn_id($msn_id = null)
    {
      if ( (!(@isset($this->msn_id))      && !(isset($msn_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->msn_id) > 0) && !(isset($msn_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `msn-id`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $msn_id = $this->mysql->get_result_field();
        if ( strlen($msn_id) > 0)
        {     
          $this->msn_id=$msn_id;
        }
      }
      elseif ( (isset($msn_id)) && (strlen($msn_id) > 0) )
        $this->msn_id=$msn_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set Yahoo! Messenger id
    public function get_yahoo_id()
    {
      return $this->yahoo_id;
    }
    
    public function set_yahoo_id($yahoo_id = null)
    {
      if ( (!(@isset($this->yahoo_id))      && !(isset($yahoo_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->yahoo_id) > 0) && !(isset($yahoo_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `yahoo-id`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $yahoo_id = $this->mysql->get_result_field();
        if ( strlen($yahoo_id) > 0)
        {     
          $this->yahoo_id=$yahoo_id;
        }
      }
      elseif ( (isset($yahoo_id)) && (strlen($yahoo_id) > 0) )
        $this->yahoo_id=$yahoo_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set AOL Instant Messenger
    public function get_aim_id()
    {
      return $this->aim_id;
    }
    
    public function set_aim_id($aim_id = null)
    {
      if ( (!(@isset($this->aim_id))      && !(isset($aim_id)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->aim_id) > 0) && !(isset($aim_id)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `aim-id`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $aim_id = $this->mysql->get_result_field();
        if ( strlen($aim_id) > 0)
        {     
          $this->aim_id=$aim_id;
        }
      }
      elseif ( (isset($aim_id)) && (strlen($aim_id) > 0) )
        $this->aim_id=$aim_id;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set pupil's about me informotion
    public function get_profil_info()
    {
      return $this->profil_info;
    }
    
    public function set_profil_info($profil_info = null)
    {
      if ( (!(@isset($this->profil_info))      && !(isset($profil_info)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->profil_info) > 0) && !(isset($profil_info)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `kontakt_Info`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $profil_info = $this->mysql->get_result_field();
        if ( strlen($profil_info) > 0)
        {     
          $this->profil_info=$profil_info;
        }
      }
      elseif ( (isset($profil_info)) && (strlen($profil_info) > 0) )
        $this->profil_info=$profil_info;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set newsletter status (disabled/enabled)
    public function get_newsletter_status()
    {
      return $this->newsletter_status;
    }
    
    public function set_newsletter_status($newsletter_status = null)
    {
      if ( (!(@isset($this->newsletter_status))   && !(isset($newsletter_status)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@is_bool($this->newsletter_status)) && !(isset($newsletter_status)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `newsletter_Status`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $newsletter_status = $this->mysql->get_result_field();
        if ( is_bool($newsletter_status))
        {     
          $this->newsletter_status=$newsletter_status;
        }
      }
      elseif ( (isset($newsletter_status)) && (is_bool($newsletter_status)) )
        $this->newsletter_status=$newsletter_status;
    }
    
    /*------------------------------------------------------------------------*/
    // get/set gender
    public function get_gender()
    {
      return $this->gender;
    }

    public function set_gender($gender = null)
    {
      if ( (!(@isset($this->gender))      && !(isset($gender)) && (isset($this->user_id)) && ($this->user_id > 0))
      ||   (!(@strlen($this->gender) > 0) && !(isset($gender)) && (isset($this->user_id)) && ($this->user_id > 0)) )
      {
        $query = "SELECT `geschlecht`
                  FROM   `Schueler`
                  WHERE  `User_ID`  = '$this->user_id'";
        $this->mysql->query($query);
        $gender = $this->mysql->get_result_field();
        if ( strlen($gender) > 0)
        {     
          $this->gender=$gender;
        }
      }
      elseif ( (isset($gender)) && (strlen($gender) > 0) )
        $this->gender=$gender;
    }
  }