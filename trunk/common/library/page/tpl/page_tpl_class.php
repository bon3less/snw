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

class page_tpl
{
	var $page;

  // constructor
	function page_tpl($template = "./html/default.html")
  {
    if (!(is_array($template)))
    {
      if (file_exists($template))
        $this->page = implode("", file($template));
      else
        die("Template file $template not found.");
    }
    else
    {
      foreach( $template as $part )
      {
        if (file_exists($part))
          $this->page .= implode("", file($part));
        else
          die("Template file $part not found.");
      }
    }
  }

  // gets and returns the file content
  function parse($file)
  {
    ob_start();
    include($file);
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }

  // if file, replace with file content else replace with string
  function replace_tags($page_tmpl = array())
  {
    if (sizeof($page_tmpl) > 0)
    {
      foreach ($page_tmpl as $tpl => $data)
      {
        $data = (file_exists($data)) ? $this->parse($data) : $data;
        $this->page = eregi_replace("{".$tpl."}", $data, $this->page);
      }
    }
    else
      die("No tags designated for replacement.");
  }

  // displays the whole page
  function display_page() 
  {
    echo $this->page;
  }
}

?>