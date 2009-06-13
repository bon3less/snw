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

  //SESSION START
  session_start();
  if (!(session_is_registered("this_user"))) // not logged on
    $session = Session_manager::singleton();
  else
    $session = Session_manager::singleton($_SESSION['this_user_id']);

  // admin check
  if (session_is_registered("admin_user"))
  {
    // TODO:
    //$cat_array = add_button($cat_array);
  }
  elseif (!(session_is_registered("admin_user")))
  {
    //TODO:
    //$cat_array = del_button($cat_array);
  }

  // TODO: aus der db auslesen
  $cat_id = 0;
  $topic_id = 0;
  $cat_name = "Sch&uuml;lerportal &nbsp; &#x2794; &nbsp; Indexseite";

  //create main menu from database
  $navi = Navigation::singleton();
  $navi_name_tmpl=$navi->create_menu($navi_name_tmpl);

  // add menu to page
  $page_tmpl = array_merge ($page_tmpl,$navi_link_tmpl);
  $page_tmpl = array_merge ($page_tmpl,$navi_name_tmpl);

  /* add sub menu to page (index page shouldn't have one)
  $page_tmpl = array_merge ($page_tmpl,$submenu_link_tmpl);
  $page_tmpl = array_merge ($page_tmpl,$submenu_name_tmpl);  //*/

  // align the content with the current session vars
  if ( isset($_SESSION) && is_array($_SESSION) )
  {
    $session_param = $_SESSION;
    if (isset($session_param['this_user']))
    {
      $pupil = $session_param['pupil'];
      $nick = $pupil->get_nick_name();

      $page_tmpl = array_merge    (
        $page_tmpl, array           (
                                      "LOGIN"       => "",
                                      "LOGOFF_TEXT" => "Du bist angemeldet als <a href='cat.php?cat=1&amp;topic=11'>". $nick ."</a>.",
                                      "MENU"        => "./common/templates/menu2.tpl",
                                      "LOGOFF"      => "Abmelden"
                                    )
                                  );
    }
    else
    {
      // TODO:
      $page_tmpl = array_merge    (
        $page_tmpl, array           (
                                      "LOGOUT" => "",
                                      "MENU"  => "./common/templates/menu1.tpl",
                                      ""       => "",
                                      "" => '""'
                                    )
                                  );
    }
    if ( isset($session_param['error_msg']) && is_array($session_param['error_msg']) )
    { //*
      foreach ($session_param['error_msg'] as $key => $val)
      {
        $error_msg .= $val." ";
      }
      $page_tmpl = array_merge  (
        $page_tmpl, array         ( "ERROR_MSG_TEXT" => "$error_msg" ) );//*/
      $_SESSION['error_msg'] = "";
      $page_tmpl = array_merge  (
        $page_tmpl, array         ( "INFO_MSG" => "" ) );
    }
    else
    {
      $page_tmpl = array_merge  (
        $page_tmpl, array         ( "ERROR_MSG" => "" ) );
      if ( isset($session_param['info_msg']) && is_array($session_param['info_msg']) )
      {
        foreach ($session_param['info_msg'] as $key => $val)
        {
          $info_msg .= $val." ";
        }
        $page_tmpl = array_merge  (
          $page_tmpl, array         ( "INFO_MSG_TEXT" => "$info_msg" ) );
        $_SESSION['info_msg'] = "";
      }
      else
      {
        $page_tmpl = array_merge  (
          $page_tmpl, array         ( "INFO_MSG" => "" ) );
      }
    }
  }

  // active menu button & Page title
  $title= str_replace('&nbsp; &#x2794; &nbsp;','-', $cat_name);
  $page_tmpl = array_merge ($page_tmpl, array("TITLE"     => "$title",
                                              "NAVI_ACTIVE" => "current$cat_id",
                                              "MENU_ACTIVE" => "current_sub$topic_id",
                                              "BREADCRUMB"  => "Du befindest dich hier: <span>$cat_name</span>",
                                              "SUBMENU"     => "",
                                              ""            => "",
                                              ""            => "",
                                              ""            => "",
                                              "PAGE"        => '"'. 0 .'"',
                                              "MAIN"        => "./common/templates/vote_teaser.tpl" ));

  // create page objekt
  $page = new page_tpl($main_tmpl);
  $page->replace_tags($page_tmpl);
  $page->display_page();

?>