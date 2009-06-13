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
   * Class Submenu: creats the submenu
   */
  class Submenu
  {
    const MAX_MENU_ITEMS = 9; // max allowed amount of sub menu topics
    private $topic_id;
    private $cat_id;
    private $topic_name;
    private $topic_parent;
    private $topic_Text;
    private $topic_num; // amount of sub menu topics selectet by category
    private $num_topics;// amount of all topics
    private $mysql;
    //private $flag;
    private static $submenu; // singleton

    // constructor creates a new db connection
    public function __construct()
    {
      $config_arr = Serialization::convert();
      $this->mysql = Mysql_Class::singleton($config_arr);
    }

  /**
   * singlton function returns object submenu
   * @return object (submenu)
   */
    public static function singleton()
    {
      if (!isset(self::$submenu))
      {
        self::$submenu = new Submenu();
      }
      return self::$submenu;
    }

    // get sub menu topics
    public function get_topics($cat_id)
    {
      $query = "SELECT `Topic_ID`, `topic_Name` FROM `Topics` WHERE `Cat_ID`=$cat_id;";
      $this->mysql->query($query);
      return $this->mysql->get_result_array();
    }

  /**
   * Description: change sub menu topic name
   *
   * @param int $topic_id
   * @param string $old_topic_name
   * @param string $new_topic_name
   * @return int (bool)
   */
    public function change_topics( $topic_id, $old_topic_name, $new_topic_name )
    {
      $this->mysql->query("UPDATE `Topics` SET `topic_Name`=$new_topic_name WHERE `Topic_ID`=$topic_id AND `topic_Name`=$old_topic_name;", true);
      return $this->mysql->get_result();
    }

    // add sub menu topic
    //TODO: PARENT TOPIC FOR BREADCRUMB
    public function add_topic($topic_name, $cat_id, $topic_Text="", $flag=1)
    {
      $parent = 0; // 0 - Index Page
      $query = "INSERT into `Topics` ( Topic_ID, Cat_ID, topic_Name, topic_Parent, topic_Text, flag) VALUES ( '', $cat_id, $topic_name,$parent, $topic_text, $flag);";
      $this->mysql->query($query, true);
      return $this->mysql->insertid();
    }

  // delete sub menu topic
  public function del_topic($topic_id)
  {
    $query = "DELETE FROM `Topics` WHERE `Topic_ID` = $topic_id;";
    $this->mysql->query($query);
    return $this->mysql->get_result();
  }

    // returns topic name via topic_id
    public function get_topic_name($topic_id)
    {
      $query = "SELECT `topic_Name` FROM `Topics` where `Topic_ID` = $topic_id ;";
      $this->mysql->query($query);
      $result = $this->mysql->get_result_field();
      return $result;
    }

    // creates sub menu names from database and returns the new submenu_name_tmpl array
    // (overwrites template_config.inc.php entries)
    public function create_menu($submenu_name_tmpl,$cat_id)
    {
      $new_submenu_name_tmpl = null;
      if($this->get_topic_num($cat_id) > 0)
      {
        $topics = $this->get_topics($cat_id);
        for ( $i = 0; $i < sizeof($topics); $i++ )
        {
          if (!is_array($new_submenu_name_tmpl))
            $new_submenu_name_tmpl = array ( key($submenu_name_tmpl) => rawurldecode($topics[$i][1]) );
          else
            $new_submenu_name_tmpl = array_merge ( $new_submenu_name_tmpl, array ( key($submenu_name_tmpl) => rawurldecode($topics[$i][1]) ));
          next($submenu_name_tmpl);
        }
        return $new_submenu_name_tmpl;
      }
      return false;
    }

  /**
   * returns the amount of topics from a specific category
   * @return int
   * @param int $cat_id
   */
    public function get_topic_num($cat_id)
    {
      $this->set_topic_num($cat_id);
      return $this->topic_num;
    }

    /**
     * set the amount of topics from a specific category
     * @return void
     * @param int $cat_id
     */
    private function set_topic_num($cat_id)
    {
      $this->mysql->query("SELECT `Topic_ID` FROM `Topics` WHERE `Cat_ID`=$cat_id;"); // SELECT count(*) as `num` FROM `Topics`;
      $this->topic_num = mysql_num_rows($this->mysql->get_result());
    }

    // returns the amount of all topics
    public function get_num_topics()
    {
      $this->set_num_topics();
      return $this->num_topics;
    }

    // set amount of all topics
    private function set_num_topics()
    {
      $this->mysql->query("SELECT `Topic_ID` FROM `Topics`;"); // SELECT count(*) as `num` FROM `Topics`;
      $this->num_topics = mysql_num_rows($this->mysql->get_result());
    }



    // TODO: FLAG for languages or status
    // get flag
      // public function get_flag($topic_id)
    // {
      // $this->flag = $this->mysql->query("SELECT Cat_ID FROM `Topics` WHERE `Cat_ID`=$topic_id;");
    // }

    // // set flag (enable/disable sub menu item)
    // public function set_flag($topic_id, $flag)
    // {
      // $this->mysql->query("UPDATE `Topics` SET `flag`=$flag WHERE `Cad_ID`=$topic_id;");
      // return $this->mysql->get_result();
    // }
  }