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
 /************************************
 * MAIN HTML TEMPLATES (tmpl files)
 *************************************/

// template site configuration (html style)
$main_tmpl['header'] = "./common/templates/html/header.tmpl"; // allover head
$main_tmpl['main']   = "./common/templates/html/main.tmpl"; // allover body
$main_tmpl['footer'] = "./common/templates/html/footer.tmpl"; // allover footer

 /************************************
 * TEMPLATE SNIPPETS (tpl files)
 *************************************/

// MENU  template files
$page_tmpl = array (  "MENU"                => "./common/templates/menu.tpl",
                      "SUBMENU"             => "./common/templates/submenu.tpl",
                      ""                    => "");

// main content parts
$page_tmpl = array_merge (
$page_tmpl, array (   "ADVERTISER_TOP"      => "./common/templates/top.tpl",
                      "MAIN"                => "./common/templates/main.tpl",
                      "LEFT"                => "./common/templates/left.tpl",
                      "RIGHT"               => "./common/templates/right.tpl",
                      "VOTE_CATS"           => "./common/templates/vote_teaser.tpl",
                      ""                    => "",
                      ""                    => "",
                      "FOOTER"              => "./common/templates/footer.tpl",
                      ""                    => "",
                      ""                    => "",
                      ""                    => ""));


// ADVERTISEMENT placeholder
// TODO: ADVERTISER_LEFT ( css - #ads_left )
$page_tmpl = array_merge (
$page_tmpl, array (   "ADVERTISER_TOP"      => "",//./common/templates/ads_top.tpl",
                      "ADVERTISER_RIGHT"    => "",//./common/templates/ads_right.tpl",
                      "ADVERTISER_LEFT"     => "",//./common/templates/ads_left.tpl",      //   T E S T  !!!
                      "ADVERTISER_BOTTOM"   => "",//./common/templates/ads_bottom.tpl",
                      ""                    => ""));

// SEARCH templates
$page_tmpl = array_merge (
$page_tmpl, array (   "SEEK"                => "./common/templates/seek.tpl",
                      ""                    => "",
                      ""                    => ""));

// LOGIN templates
$page_tmpl = array_merge (
$page_tmpl, array (   "LOGIN"               => "./common/templates/login.tpl",
                      "LOGOUT"              => "./common/templates/logout.tpl",
                      ""                    => "")); 

// INFO_MSG templates
$page_tmpl = array_merge (
$page_tmpl, array (   "INFO_MSG"            => "./common/templates/info_msg.tpl",
                      "ERROR_MSG"           => "./common/templates/error_msg.tpl",
                      ""                    => ""));

// dynamic sub content parts (templates for {MAIN}, {LEFT} and {RIGHT})
$page_tmpl = array_merge (
$page_tmpl, array (   "CONTENT_MAIN"        => "",
                      "CONTENT_LEFT"        => "",
                      "CONTENT_RIGHT"       => "",
                      ""                    => ""));

 /************************************
 * VARIABLES
 *************************************/

 /*------------------------------------------------------------------------*/
 // MENU link configuratioin
$navi_link_tmpl = array ( "_HOME"       => '"cat.php?cat=1"',       //&amp;cat_name={HOME}        url for Home
                          "_VOTE"       => '"cat.php?cat=2"',       //&amp;cat_name={VOTE}        Voting
                          "_RANKING"    => '"cat.php?cat=3"',       //&amp;cat_name={RANKING}     TOP%20-%20Listen
                          "_NEWS"       => '"cat.php?cat=4"',       //&amp;cat_name={NEWS}
                          "_REGISTER"   => '"cat.php?cat=5"',       //&amp;cat_name={REGISTER}
                          "_ABOUT"      => '"cat.php?cat=6"',       //&amp;cat_name={ABOUT}       %26Uuml;ber%20Uns
                          "_LOGOFF"     => '"logout.php?logout=1"', //&amp;cat_name={LOGOFF}
                          "_SEARCH"     => '"search.php"');         //&amp;cat_name={SEARCH}

// MENU name configuratioin
$navi_name_tmpl = array ( "HOME"        => "Startseite", // name for Home
                          "VOTE"        => "Bewerten",
                          "RANKING"     => "TOP - Listen",
                          "NEWS"        => "Neuigkeiten",
                          "REGISTER"    => "Registrieren",
                          "ABOUT"       => "Über Uns",
                          "LOGOFF"      => "Abmelden",
                          "SEARCH"      => "Suchen");

/*------------------------------------------------------------------------*/
// SUBMENU_01 link configuratioin
$submenu_link_tmpl[0] = array ( "_PROFILE"   => '"cat.php?cat=1&amp;topic=11"', // Schueler Voting
                                "_FRIENDS"   => '"cat.php?cat=1&amp;topic=12"', // Lehrer Voting
                                "_MESSAGES"  => '"cat.php?cat=1&amp;topic=13"', // Schul Voting
                                "_IMAGES"    => '"cat.php?cat=1&amp;topic=14"',
                                "_SEARCH"    => '"search.php?topic=15"');

// SUBMENU_01 name configuratioin
$submenu_name_tmpl[0] = array ( "PROFILE"    => "Mein Profil",
                                "FRIENDS"    => "Freunde",
                                "MESSAGES"   => "Messages",
                                "IMAGES"     => "Fotos",
                                "SEARCH"     => "Suchen");

/*------------------------------------------------------------------------*/
// SUBMENU_02 link configuratioin
$submenu_link_tmpl[1] = array ( "_P_VOTE"    => '"cat.php?cat=2&amp;topic=1"', // Schueler Voting
                                "_T_VOTE"    => '"cat.php?cat=2&amp;topic=2"', // Lehrer Voting
                                "_S_VOTE"    => '"cat.php?cat=2&amp;topic=3"', // Schul Voting
                                "_SEARCH"    => '"search.php?topic=16"');

// SUBMENU_02 name configuratioin
$submenu_name_tmpl[1] = array ( "P_VOTE"     => "Mitsch&uuml;ler Benoten",
                                "T_VOTE"     => "Lehrer Benoten",
                                "S_VOTE"     => "Schulen Benoten",
                                "SEARCH"     => "Suchen");

/*------------------------------------------------------------------------*/
// SUBMENU_03 link configuratioin
$submenu_link_tmpl[2] = array ( "_P_TOP"    => '"cat.php?cat=3&amp;topic=4"', // Schueler TOP List
                                "_T_TOP"    => '"cat.php?cat=3&amp;topic=5"', // Lehrer TOP List
                                "_S_TOP"    => '"cat.php?cat=3&amp;topic=6"', // Schul Top List
                                "_SEARCH"    => '"search.php?topic=17"');

// SUBMENU_03 name configuratioin
$submenu_name_tmpl[2] = array ( "P_TOP"      => "Sch&uuml;ler TOP-Listen",
                                "T_TOP"      => "Lehrer TOP-Listen",
                                "S_TOP"      => "Schulen TOP-Listen",
                                "SEARCH"     => "Suchen");

/*------------------------------------------------------------------------*/
// SUBMENU_04 link configuratioin
$submenu_link_tmpl[3] = array ( "_WEEK_TOPIC"     => '"cat.php?cat=4&amp;topic=7"', // Topic of the Week
                                "_SCHOOLYARD"     => '"cat.php?cat=4&amp;topic=8"', // News from the schoolyard
                                "_NEW_MEMBER"     => '"cat.php?cat=4&amp;topic=9"', // New Member
                                "_FUN"            => '"cat.php?cat=4&amp;topic=10"',// Fun Stuff
                                "_SEARCH"         => '"search.php?topic=18"');

// SUBMENU_04 name configuratioin
$submenu_name_tmpl[3] = array ( "WEEK_TOPIC"      => "Thema der Woche",
                                "SCHOOLYARD"      => "Schulnhof-Tratsch",
                                "NEW_MEMBER"      => "Neue Mitglieder",
                                "FUN"             => "Fun Stuff",
                                "SEARCH"          => "Suchen");

/*------------------------------------------------------------------------*/
/* SUBMENU_05 link configuratioin
$submenu_link_tmp[4] = array (  "_SUB0"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SUB1"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SUB2"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SUB3"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SUB4"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SUB5"      => '"cat.php?cat=5&amp;topic=100"',
                                "_SEARCH"    => '"search.php"');

// SUBMENU_05 name configuratioin
$submenu_name_tmpl[4] = array ( "SUB10"      => "10",
                                "SUB11"      => "11",
                                "SUB12"      => "12",
                                "SUB13"      => "13",
                                "SUB14"      => "14",
                                "SUB15"      => "15",
                                "SEARCH"     => "Suchen");

/*------------------------------------------------------------------------*/
/* SUBMENU_06 link configuratioin
$submenu_link_tmpl[5] = array ( "_SUB0"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SUB1"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SUB2"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SUB3"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SUB4"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SUB5"      => '"cat.php?cat=6&amp;topic=100"',
                                "_SEARCH"    => '"search.php"');

// SUBMENU_06 name configuratioin                       
$submenu_name_tmpl[5] = array ( "SUB10"      => "10",
                                "SUB11"      => "11",
                                "SUB12"      => "12",
                                "SUB13"      => "13",
                                "SUB14"      => "14",
                                "SUB15"      => "15",
                                "SEARCH"     => "Suchen");


/*------------------------------------------------------------------------*/                      
// general and misc link ulrs
$page_tmpl = array_merge (
$page_tmpl, array (   "_LOGO"       => '"index.php"',
                      "_TERMS"      => '"index.php?cat=0"',
                      "_SITE_INFO"  => '"#"',
                      "_LINKS"      => '"index.php?cat=0"',
                      "_SUPPORT"    => '"index.php?cat=7"',
                      "_SERVICE"    => '"index.php?cat=8"',
                      "_FAQ"        => '"#"',
                      ""            => '"#"',
                      ""            => '"#"',        
                      ""            => '"#"',
                      ""            => '"#"'));
                      
// general and misc link names                       
$page_tmpl = array_merge (
$page_tmpl, array (   "TERMS"       => "AGB",
                      "SITE_INFO"   => "Impressum",
                      "LINKS"       => "Nachbar Seiten",
                      "SUPPORT"     => "Hilfe",
                      "SERVICE"     => "Dienste",
                      "FAQ"         => "FAQ",
                      ""            => "#", 
                      ""            => "#", 
                      ""            => "#", 
                      ""            => "#",
                      ""            => "#"));
                      
/*------------------------------------------------------------------------*/ 
// head and meta tags
$page_tmpl = array_merge (
$page_tmpl, array (   "TITLE"       => "Sch&uuml;lerportal", // page title (default)
                      "DESCRIPTION" => "Sch&uuml;er bewerten Sch&uuml;er - Sch&uuml;er bewerten Lehrer - Sch&uuml;er bewerten Schulen",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => ""));

/*------------------------------------------------------------------------*/ 
// CSS files and config                       
$page_tmpl = array_merge (
$page_tmpl, array (   "CSS1"        => '"common/css/snw_style.css"',
                      "CSS2"        => '"common/css/snw_menu.css"',
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => ""));
                      
// ACTIVE MENU button
$page_tmpl = array_merge (
$page_tmpl, array (   "NAVI_ACTIVE" => "current0", // activ navi button ( default: 0 -> HOME )
                      "MENU_ACTIVE" => "current10", // activ menu button ( default: 0 -> NO TOPIC )
                      ""            => "",
                      ""            => "",
                      ""            => "",
                      ""            => ""));

/*------------------------------------------------------------------------*/                      
// JS - javascript files
$page_tmpl = array_merge (
$page_tmpl, array (   "JS1"         => '"common/js/snw_common.js"',
                      "JS2"         => '"common/js/snw_register.js"',
                      ""            => "",
                      ""            => "",
                      ""            => ""));

/*------------------------------------------------------------------------*/ 
// images and advertisment
$page_tmpl = array_merge (
$page_tmpl, array (   "LOGO"        => '"common/img/logo/logo.gif"',
                      ""            => "",
                      ""            => ""));

/*------------------------------------------------------------------------*/
// captions and misc variables
$page_tmpl = array_merge (
$page_tmpl, array (   "CAPTION_H1"      => "Das Sch&uuml;lerportal",
                      "LOGOFF_TEXT"     => "Angemeldet", // als <span>". $nick ."</span>.",
                      "INFO_MSG_TEXT"   => "",   //Info-Nachricht
                      "ERROR_MSG_TEXT"  => "",   //Fehler-Meldung
                      ""                => "",
                      ""                => "",
                      ""                => ""));

?>