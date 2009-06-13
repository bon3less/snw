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
class Serialization
{
  static function decode($encoded_obj)
  {
    $result=false;
    if (is_array($encoded_obj))
    foreach ($encoded_obj as $encoded_string => $value)
      $result = unserialize(base64_decode($value));
    elseif ( isset($encoded_obj) && !is_array($encoded_obj) )
      $result = unserialize(base64_decode($encoded_obj));
    return $result;
  }
  static function encode($decoded_obj)
  {
    $result=false;
    if (is_array($decoded_obj))
    foreach ($decoded_obj as $decoded_string => $value)
      $result = base64_encode(serialize($value));
    elseif ( isset($decoded_obj) && !is_array($decoded_obj) )
      $result = base64_encode(serialize($decoded_obj));
    return $result;
  }
  static function convert()
  {
    $new_conf_arr = null;
    $config_arr = db_config();
    if (!is_array($config_arr))
      return false;
    foreach($config_arr as $config)
    {
      $res = Serialization::decode($config);
      if (!is_array($new_conf_arr))
        $new_conf_arr = array($res);
      else
        array_push($new_conf_arr,$res);
    }
    return $new_conf_arr;
  }
}