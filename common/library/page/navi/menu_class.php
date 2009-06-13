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

/**
 * Class Navigation: creates the main menu
 *
 */
class Navigation
{
  const MAX_NAVI_ITEMS = 6; // max allowed amount of navigation categories
  private $cat_id;
  private $cat_name;
  private $cat_num; // amount of navigation categories
  private $mysql;
  //private $flag;

  private static $navigation; // singleton

  // constructor creates a new db connection
  public function __construct()
  {
    $config_arr = Serialization::convert();
    $this->mysql = Mysql_Class::singleton($config_arr);
    $this->set_num_cats();

    // TODO: (performance tests)
    //creating the whole object at once (performance test)
    //$this->flag = get_flag();
    //$this->cat_id = get_cat_id();
    //$this->cat_name = get_cat_name();
    //$this->cat_num = get_num_cats();
  }

/**
 * singlton function returns object navigation
 * @return object (navigation)
 */
  public static function singleton()
  {
    if (!isset(self::$navigation))
    {
      self::$navigation = new Navigation();
    }
    return self::$navigation;
  }

/**
 * get navi menu categories
 * @return array
 */
  public function get_categories()
  {
    $query = "SELECT `Cat_ID`, `cat_Name` FROM `Categories`;";
    $this->mysql->query($query);
    return $this->mysql->get_result_array();
  }

/**
 * change navi menu category name
 * @return int (bool)
 */
  public function change_categories( $old_navi_name, $new_navi_name, $cat_id )
  {
    $this->mysql->query("UPDATE `Categories` SET `cat_Name`=$new_navi_name WHERE `Cat_ID`=$cat_id AND `cat_Name`=$old_navi_name;", true);
    return $this->mysql->get_result();
  }

/**
 * add navi menu categories
 * @return int
 * TODO: PARENT CATEGORY FOR BREADCRUMB
 */
  public function add_categories($cat_name)
  {
    $parent = 0; // 0 - Index Page
    $query = "INSERT INTO `Categories` ( Cat_ID, cat_Name, parent) VALUES ('', $cat_name, $parent);";
    $this->mysql->query($query, true);
    return $this->mysql->insertid();
  }

/**
 * delete navi entry
 * @return int (bool)
 */
  public function del_categories($cat_id)
  {
    $query = "DELETE FROM `Categories` WHERE `Cat_ID` = $cat_id;";
    $this->mysql->query($query);
    return $this->mysql->get_result();
  }

/**
 * returns category name via cat_id
 * @return string
 */
  public function get_cat_name($cat_id)
  {
    $query = "SELECT cat_Name FROM `Categories` where `Cat_ID` = $cat_id ;";
    $this->mysql->query($query);

    $result = $this->mysql->get_result_field();
    return $result;

  }

/**
 * creates navi menu names from database and returns the new navi_name_tmpl array
 * (overwrites template_config.inc.php entries)
 * @return array
 */
  public function create_menu($navi_name_tmpl)
  {
    $new_navi_name_tmpl = null;
    $categories = $this->get_categories();
    for ( $i = 0; $i < sizeof($categories); $i++ )
    {
      if (!is_array($new_navi_name_tmpl))
        $new_navi_name_tmpl = array ( key($navi_name_tmpl) => rawurldecode($categories[$i][1]) );
      else
        $new_navi_name_tmpl = array_merge ( $new_navi_name_tmpl, array ( key($navi_name_tmpl) => rawurldecode($categories[$i][1]) ));
      next($navi_name_tmpl);
    }
    return $new_navi_name_tmpl;
  }

/**
 * sets the amount of categories
 *
 * @return void
 */
  private function set_num_cats()
  {
    $this->mysql->query("SELECT Cat_ID FROM `Categories`;"); // SELECT count(*) as `num` FROM `Categories`;
    $this->cat_num = mysql_num_rows($this->mysql->get_result());
  }

/**
 * returns the amount of categories
 *
 * @return int
 */
  public function get_num_cats()
  {
    return $this->cat_num;
  }


  // TODO: FLAG for languages or status
  // get flag
    // public function get_flag($cat_id)
  // {
    // $this->flag = $this->mysql->query("SELECT Cat_ID FROM `Categories` WHERE `Cat_ID`=$cat_id;");
  // }

  // // set flag (enable/disable navi menu item)
  // public function set_flag($cat_id, $flag)
  // {
    // $this->mysql->query("UPDATE `Categories` SET `flag`=$flag WHERE `Cad_ID`=$cat_id;");
    // return $this->mysql->get_result();
  // }



}

?>