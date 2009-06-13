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

class Content
{	
  private $content_id;
  private $cat_id;
  private $topic_id;
  private $content_name;
  private $content_caption;
  private $content_text;
  private $content_position; // main, left, right

  function __construct($cat_id, $topic_id)
  {
    $this->cat_id= $cat_id;
    $this->topic_id= $topic_id;
    
  }
  
  /*------------------------------------------------------------------*/
  // getter methods, returning each of the content properties
  
  // get content id
  public function get_content_id()
  {
    return $this->content_id;
  }
  // get category id
  public function get_cat_id()
  {
    return $this->cat_id;
  }
  // get topic id
  public function get_topic_id()
  {
    return $this->topic_id;
  }
  //get content name
  public function get_content_name()
  {
    return $this->content_name;
  }
  // get content caption
  public function get_content_caption()
  {
    return $this->content_caption;
  }
  //get content text
  public function get_content_text()
  {
    return $this->content_text;
  }
  // get content position
  public function get_content_position()
  {
    return $this->content_position;
  }
  
  /*------------------------------------------------------------------*/
  // set content properties at once ought to be called from the 
  // Content_Controler class only.
  
  // set content 
  public function set_content($md_array)
  {
    // set member variables
    list($property_array) = $md_array; // gets the first dimension
    list(   $this->content_id,
             $this->content_name,
             $this->content_caption, 
             $this->content_text,
             $this->content_position
         ) = $property_array;            
  }
  
  // test
  public function get_content()
  {
    echo "$this->content_id,
          $this->cat_id,
          $this->topic_id,
          $this->content_name,
          $this->content_caption, 
          $this->content_text,
          $this->content_position";
    //return $this->content;
  }
} 