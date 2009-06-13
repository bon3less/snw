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

  class Breadcrumb
  {
    //creates the breadcrumb and returns the whole breadcrumb string
    static function select_breadcrumb($cat_id, $cat_name, $topic_id, $topic_name, $url)
    {
      // TODO: breadcrumb generation with topics included (+ sub menu)
      //
      if ($topic_id == 0 || strlen($topic_id)==0)
        $bc = "<a href='".$url."index.php'>Sch&uuml;lerportal</a> &nbsp; &#x2794; &nbsp; $cat_name";
      else
        $bc = "<a href='".$url."index.php'>Sch&uuml;lerportal</a> &nbsp; &#x2794; &nbsp; <a href='".$url."cat.php?cat=".$cat_id."'>$cat_name</a> &nbsp; &#x2794; &nbsp; $topic_name";
      return $bc;
    }

  }
?>