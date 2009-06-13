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

  class Url_request_validation
  {
    // validates category ID and topic ID from the url query string
    // cat_max = 6 (max amount of possible categories)
    // top_max = amount of topics
    static function check_id( $cat_max, $top_max )
    {
      if (!$_GET['cat'] || strlen($_GET['cat']) == 0 )
        return false;
      if( is_numeric($_GET['cat']) && $_GET['cat']>=0 && $_GET['cat'] <= $cat_max )
      {
        if( !$_GET['topic'] || strlen($_GET['topic']) == 0 )
          return true;
        if( is_numeric($_GET['topic']) && $_GET['topic']>=0 && $_GET['topic'] <= $top_max )
          return true;
      }
      else
      {
      	$url = Redirection::get_base_url();
    		Redirection::redirect($url."index.php");
      }
    }
  }
 ?>