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

  // configuration files
  include_once("library/config/template_config.inc.php");
  include_once("library/config/db_config.inc.php");
  //include_once("library/config/*_config.inc.php");

  // misc classes
  include_once("library/common_classes.php");

  // validation library
  include_once("library/validation/url_request_validation_class.php");
  include_once("library/validation/spam_blocker_class.php");
  include_once("library/validation/user_validation_class.php");
  include_once("library/validation/session_manager_class.php");
  include_once("library/validation/profil_validation_class.php");
  //include_once("library/validation/*_class.php");

  // verification library
  include_once("library/verify/db_verification_class.php");
  //include_once("library/verify/*_class.php");

  // database library
  include_once("library/db/mysql_class.php");
  include_once("library/db/mysql_installer_class.php");

  // user library
  include_once("library/user/user_interface.php");
  include_once("library/user/user_class.php");
  include_once("library/user/user_registration_class.php");
  //include_once("library/user/*_class.php");

  // common functions
  include_once("library/common_functions.php");

  // admin library
  //include_once("library/admin/*_class.php");

  // content library
  include_once("library/content/session_object_handler_class.php");
  include_once("library/content/content_controler_class.php");
  include_once("library/content/portal/content_class.php");
  include_once("library/content/school/curriculum_class.php");
  include_once("library/content/school/form_grade_class.php");
  include_once("library/content/school/pupil_class.php");
  include_once("library/content/school/pupil_address_class.php");
  include_once("library/content/school/friend_class.php");
  include_once("library/content/school/school_class.php");
  include_once("library/content/school/teacher_class.php");
  include_once("library/content/portal/profile_class.php");
  //include_once("library/content/*_class.php");

  // page library
  include_once("library/page/tpl/page_tpl_class.php");
  include_once("library/page/navi/menu_class.php");
  include_once("library/page/navi/submenu_class.php");
  include_once("library/page/navi/breadcrumb_class.php");
  //include_once("library/page/*");
?>