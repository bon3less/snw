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

  define('THIS', 'true');
  $snw_root = './';
  include($snw_root.'common/lib.inc.php');

  // SESSION START
  session_start();
  if (!(session_is_registered("this_user"))) // not logged on
    $session = Session_manager::singleton();
  else
    $session = Session_manager::singleton($_SESSION['this_user_id']);

  
  if ( !(strlen($HTTP_POST_VARS['words']) > 0) || (strtolower($HTTP_POST_VARS['words'])) == "suchen")
  {
    $url = Redirection::get_base_url();
    Redirection::meta_redirect($url."index.php");
  }
  if ( ($HTTP_POST_VARS['page']) == 1 )
  {
    //TODO: - throw search result back to the same page
    //      - page number in tpl needs to be vaiable
  }
  
?>