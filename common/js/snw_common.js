// javascript file: snw_general.js
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


// German special characters
function get_special_char(chr)
{
  if (chr == "ae")
   return String.fromCharCode(228)
  if (chr == "oe")
   return String.fromCharCode(246)
  if (chr == "ue")
   return String.fromCharCode(252)
  if (chr == "ss")
   return String.fromCharCode(223)
  if (chr == "AE")
   return String.fromCharCode(196)
  if (chr == "OE")
   return String.fromCharCode(214)
  if (chr == "UE")
   return String.fromCharCode(220)
  return false;
}

// trim whitespaces
function trim(str)
{
  return str.replace(/^\s+|\s+$/g, "")
}

/* checks a string value */
function val_check(id)
{
  var node = document.getElementById(id);
  
  // by leaving the focus without a value, set the input field 
  // back to the default value
  if( (trim(node.value).length) == 0 )
  {
    if (id == "words") { node.value = "Suchen";}
	//if (id == "acc_id") { node.value = "Benutzername"; }
	//if (id == "nick_name") { node.value = "Nickname"; }
  	return;
  }
  if( node.value == "Suchen" )
  { 
  	node.value = "";  	
  	return;
  }
}

//check if login fields has set values 
function check_login(id)
{
  var node = document.getElementById(id);
  var el=document.forms['loginform'].elements;
  
  if( (trim(el['acc_id'].value) ==0) || (trim(el['acc_passwd'].value) ==0))
  {
    el['acc_id'].style.backgroundColor="#FFC0CB";
    el['acc_passwd'].style.backgroundColor="#FFC0CB";
    return false;
  }
  else
  {
    el['acc_id'].style.backgroundColor="#F0FFF0";
    el['acc_passwd'].style.backgroundColor="#F0FFF0";
    return true;
  } 
}



















