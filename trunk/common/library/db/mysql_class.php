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
class Mysql_Class
{
  private $query;
  private $result;
  private $link;

  private static $mysql_class; // singleton

  // constructor establishes a connection to the database
  private function __construct($config)
  {
    if ( is_array($config) )
    {
      $this->link = mysql_connect($config[0],$config[1],$config[2]); //  or die(mysql_errno().": ".mysql_error())
      if ( !is_resource($this->link) )
      {
        die("Failed to connect to the server\n".mysql_errno($this->link).": ".mysql_error($this->link));
      }
      mysql_select_db($config[3]) or die(mysql_errno().": ".mysql_error());
    }
    else
    {
      // TODO: THROW EXCEPTION
    }
  }

  // singlton function returns object mysql_class
  public static function singleton($config)
  {
    if (!isset(self::$mysql_class))
    {
      self::$mysql_class = new Mysql_Class($config);
    }
    return self::$mysql_class;
  }

  public function query($query, $check = true)
  {
    $this->query = $query;
    if($check)
      $this->execute_query();
  }

  //executes mysql query
  private function execute_query()
  {
    $this->result = mysql_query($this->query, $this->link) or die(mysql_errno().": ".mysql_error());
  }
  
  // protects against sql injection
  public function db_escape($data)
  {
    if (is_array($data))
    {
      foreach ($data as $name=>$value)
      {
        if( get_magic_quotes_gpc() )
          $data[$name] = mysql_real_escape_string(stripslashes($value));
        else
          $data[$name] = mysql_real_escape_string($value);
      }
    }
    else
    {
      if ( get_magic_quotes_gpc() )
        $data = mysql_real_escape_string(stripslashes($data));
      else
        $data = mysql_real_escape_string($data);
    }
    return $data;
  }
  
  // returns query result
  public function get_result()
  { 
    return $this->result;
  }

  // returns a query result with only one field
  public function get_result_field($field = 0)
  {
    $result = $this->result;
    if (!$result)
      return false;
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
      return false;
    $result = mysql_result($result, 0, $field);
    return $result;
  }

  // returns information about a column of the result list into an nested array
  public function get_result_field_list($field = 0)
  {
    $result = $this->result;
    if (!$result)
      return false;
    $result_arr = mysql_fetch_assoc($result);
    if (!is_array($result_arr))
      return false;
    $result_list = $result_arr["$field"];
    return $result_list;
  }

  // returns the query result set as array
  public function get_result_array()
  {
    $res_array = array();
    for ( $count = 0; $row = mysql_fetch_array($this->result); $count++ )
      $res_array[$count] = $row;
    return $res_array;
  }
  
  // returns the amount of matching rows
  public function get_num_rows()
  {
    $result = $this->result;
    if (!$result)
      return false;
    $num_rows = mysql_num_rows($result);
    if ( !is_numeric($num_rows) )
      return false;
    return $num_rows;
  }

  // gets the last inserted id
  public function insertid()
  {
    return mysql_insert_id();
  }
} 