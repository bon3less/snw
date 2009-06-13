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

  $time_start = microtime(true);

  define('THIS', 'true');
  $snw_root = './';
  include($snw_root.'common/lib.inc.php');

  if (!$HTTP_GET_VARS > 0 )
  {
    $url = Redirection::get_base_url();
    Redirection::redirect($url."index.php");
  }
  else
  {
    //SESSION START
    session_start();
    if (!(session_is_registered("this_user"))) // not logged on
      $session = Session_manager::singleton();
    else
      $session = Session_manager::singleton($_SESSION['this_user_id']);

    // create menu objects
    $navi = Navigation::singleton();
    $submenu = Submenu::singleton();

    // create breadcrumb
    $cat_id = 0;
    $topic_id = 0;
    $cat_name = "Sch&uuml;erportal";
    $cat_max = $navi->get_num_cats();
    $top_max = $submenu->get_num_topics();
    $valid = Url_request_validation::check_id($cat_max, $top_max); // validate url request
    if( $valid )
    {
      $cat_id=$_GET['cat'];
      $topic_id = $_GET['topic'];
      $cat_name = $navi->get_cat_name($cat_id);
      if(strlen($topic_id)>0)
        $topic_name = $submenu->get_topic_name($topic_id);
    }
    $breadcrumb = Breadcrumb::select_breadcrumb($cat_id, $cat_name, $topic_id, $topic_name, $url);

    // check if the  user has accsess to the page
    if ( !(session_is_registered("this_user")) && $cat_id >= 0
    &&   !(session_is_registered("this_user")) && $cat_id <= 3 )
    {
      $info_msg = array( "login" => "<a href='cat.php?cat=5' title='Anmeldung'>Anmeldung erforderlich!</a>");
      if ( is_array( $_SESSION['info_msg'] ) )
        $_SESSION['info_msg'] = array_merge( $_SESSION['info_msg'], $info_msg);
      else
        $_SESSION['info_msg'] = $info_msg;
      Redirection::redirect($url."index.php");
    }
    else
    {
      //create main menu from database
      $navi_name_tmpl=$navi->create_menu($navi_name_tmpl);

      // create sub menu from database
      $submenu_name_tmpl[$cat_id-1]=$submenu->create_menu($submenu_name_tmpl[$cat_id-1],$cat_id);

      // add menu to page
      $page_tmpl = array_merge ($page_tmpl,$navi_link_tmpl);
      $page_tmpl = array_merge ($page_tmpl,$navi_name_tmpl);

      //* add or del sub menu from page
      if ( is_array( $submenu_name_tmpl[$cat_id-1] ) )
      {
        $page_tmpl = array_merge ($page_tmpl, array("SUBMENU" => "./common/templates/submenu$cat_id.tpl"));
        $page_tmpl = array_merge ($page_tmpl,$submenu_link_tmpl[$cat_id-1]);
        $page_tmpl = array_merge ($page_tmpl,$submenu_name_tmpl[$cat_id-1]);
      }
      else
      {
        $page_tmpl = array_merge ($page_tmpl, array("SUBMENU" => ""));
      }

      // preparing the current content via content controller
      $cc = Content_Controller::singleton($cat_id, $topic_id);
      $content = $cc->get_content_object();
      $content = $cc->get_tmpl_content_array();
      if (is_array($page_tmpl))
        $page_tmpl = array_merge ($page_tmpl,$content);
      else
        $page_tmpl = $content;
      //echo "<pre>";
      //print_r($content);
      //echo "</pre>";

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
                                          "LOGOFF"      => "Abmelden",
                                          ""            => "",
                                          ""            => ""
                                        )
                                      );

          ///////////////////////TODO:  IF CORRECT CATEGORY & TOPIC ff.
          // PROFILE cat=1 & topic=11
          $profile = new Profile($session_param, $session);
          $profile_arr = $profile->get_profile();
          if ( is_array($profile_arr) )
            $page_tmpl = array_merge( $page_tmpl, $profile_arr );

          // voting














        }
        else
        {
          // TODO:
          $page_tmpl = array_merge    (
            $page_tmpl, array           (
                                          "LOGOUT"  => "",
                                          "MENU"    => "./common/templates/menu1.tpl",
                                          "" => '""'
                                        )
                                      );
        }
        // add error & info messages to the page template array, to show them to the user
        if ( isset($session_param['error_msg']) && is_array($session_param['error_msg']) )
        {  //*
          //die('ERROR!');
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
        { //die('INFO!');
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
      $page_tmpl = array_merge  (
        $page_tmpl, array         (
                                      "TITLE"         => "$cat_name - Sch&uuml;lerportal",
                                      "NAVI_ACTIVE"   => "current$cat_id",
                                      "MENU_ACTIVE"   => "current_sub$topic_id",
                                      "BREADCRUMB"    => "Du befindest dich hier: <span>$breadcrumb</span>",
                                      "PAGE"          => '"'.$cat_id.'"'
                                    )
                                  );

      // create page objekt
      $page = new page_tpl($main_tmpl);
      $page->replace_tags($page_tmpl);
      $page->display_page();
    }
  }
  $time_end = microtime(true);
  $time = round(($time_end - $time_start),4);
  //echo "<p style='font-size: small'>Script execution time: ". $time ." seconds.</p>";
?>