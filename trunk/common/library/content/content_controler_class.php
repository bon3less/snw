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
class Content_Controller
{
  private $cat_id;
  private $topic_id;
  private $content;
  private $property_array; // content without cat_id, topic_id
  private $tpl_file;
  private $tpl_array;
  private static $mysql;

  private static $content_controller; // singleton

  // constructor
  private function __construct($cat_id, $topic_id)
  {
    // create db connection instance
    $config_arr = Serialization::convert();
    $this->mysql = Mysql_Class::singleton($config_arr);
    // set member variables
    $this->content = null;
    $this->property_array = null;
    $this->cat_id = $cat_id;
    $this->topic_id = $topic_id;
    $this->content = new Content($cat_id, $topic_id);
    // method calls
    $this->set_property_array();
    $this->set_contetnt_object();
    $this->set_template_file();
    $this->set_position_array_variable();

  }

  // singlton function returns object content_controler
  public static function singleton($cat_id, $topic_id)
  {
    if (!isset(self::$content_controller))
    {
      self::$content_controller = new Content_Controller($cat_id, $topic_id);
    }
    return self::$content_controller;
  }

  /*------------------------------------------------------------------*/
  //  Getting the content properties from the database.
  //  Instanciates a content object for easier handling.

  // look up content from db
  private function set_property_array()
  {
    if ( ( (is_numeric($this->cat_id))  && ($this->cat_id   > 0) )
    && ( (!is_numeric($this->topic_id)) || ($this->topic_id <= 0) ) )
    {
      $query = "SELECT `CID`, `content_Name`, `content_Caption`, `content_Text`, `content_Position` FROM `Content` WHERE `Cat_ID`=".$this->cat_id.";";

    $this->mysql->query($query);
    $this->property_array =  $this->mysql->get_result_array();
    }
    elseif ( (  is_numeric($this->cat_id)    && $this->cat_id   >= 0 )
    &&        ( is_numeric($this->topic_id)  && $this->topic_id > 0 ) )
    {
      $query = "SELECT `CID`, `content_Name`, `content_Caption`, `content_Text`, `content_Position` FROM `Content` WHERE `Cat_ID` = ".$this->cat_id." AND `Topic_ID` = ".$this->topic_id.";";

    $this->mysql->query($query);
    $this->property_array =  $this->mysql->get_result_array();
    }
    else
    {
      $this->property_array  = "No content available!";
    }
  }

  // returns the property array
  public function get_property_array()
  {
    return $this->property_array;
  }

  // returns content as object
  public function get_content_object()
  {
    return $this->content;
  }
  // fills the content properties with data from the database
  private function set_contetnt_object()
  {
    $this->content->set_content($this->property_array);
  }

  /*------------------------------------------------------------------*/
  //  Preparing the template array.

  // sets the proper template file for the current content
  // TODO: CREATE NEW TEMPLATE FILE PLUS CODE
  private function set_template_file()
  {
    // set template file
    $content_name = $this->content->get_content_name();
    $topic_id = $this->content->get_topic_id();
    if ( (isset($content_name)) && (strlen($content_name) > 0) )
    {
      // if ( $topic_id == '0' )
      // {
        // // TODO: no sub menu, perhaps another tpl ?
      // }
      // else
      if ($content_name == 'search')
      {
        // TODO: if search then .php
      }
      else
      {
        $tpl_file = sprintf("./common/templates/%s.tpl", $content_name );
        file_exists($tpl_file) ? $this->tpl_file=$tpl_file : fopen($tpl_file, "a+");  // "w+"

        // TODO: admin area - create tpl-file (write access to this directory is needed)
      }
    }
  }

  // set content position array to define the position variable in
  // the template array (CONTENT_MAIN, CONTENT_LEFT, CONTENT_RIGH)
  // TODO: db <- (1 = main, 2 = left, 4 = right)  <- (1,2,4)
  //          -> (3 = main + left, 6 = left + right, 5 = main + right, 7 = all three)
  private function set_position_array_variable()
  {
    $content_position = $this->content->get_content_position();
    if ( isset($content_position) )
    {
      (strcasecmp($content_position, "main") == 0) ? $this->tpl_array=array("CONTENT_MAIN"  => "$this->tpl_file") : null;
      (strcasecmp($content_position, "left") == 0) ? $this->tpl_array=array("CONTENT_LEFT"  => "$this->tpl_file") : null;
      (strcasecmp($content_position, "right")== 0) ? $this->tpl_array=array("CONTENT_RIGHT" => "$this->tpl_file") : null;
      /* TODO: else case */
    }
  }

  // returns the template array containing the content caption plus text
  public function get_tmpl_content_array()
  {
    if (is_array($this->tpl_array))
    $this->tpl_array = array_merge(
    $this->tpl_array, array         (
                                        "CONTENT_CAPTION" =>  $this->content->get_content_caption(),
                                        "CONTENT_TEXT"    =>  $this->content->get_content_text()
                                      )
                                   );
    else
    $this->tpl_array = array (
                                "CONTENT_CAPTION" =>  $this->content->get_content_caption(),
                                "CONTENT_TEXT"    =>  $this->content->get_content_text()
                             );
    return $this->tpl_array;
  }

  /*------------------------------------------------------------------*/
  //  returns the template array for the profile.
  public function get_foo($foo = null )
  {}

  /*------------------------------------------------------------------*/
  //  returns the template array for the profile.
  public function show_foo($foo = null )
  {}
}
















