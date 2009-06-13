// javascript file: snw_common.js
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


// german special characters
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

// marks select-fields which have to be filled ( TODO: Opera )
function mark_select(id1,id2,id3)
{
  var el=document.forms['register_form'].elements; //form member  
  if (el['country_school'].value == "NONE")
  {  
    var node = document.getElementById(id1);
    el['country_school'].style.backgroundColor="#FFC0CB";
    node.style.backgroundColor="#FFC0CB";
  }
  if (el['gender'].value == "NONE")
  {    
    var node = document.getElementById(id2);
    el['gender'].style.backgroundColor="#FFC0CB";
    node.style.backgroundColor="#FFC0CB";    
  }
  if (el['newsletter'].value == "NONE")
  {   
    var node = document.getElementById(id3); 
    el['newsletter'].style.backgroundColor="#FFC0CB"; 
    node.style.backgroundColor="#FFC0CB"; 
  }
}

// marks input-fields which have to be filled
function mark_mandatory(name1, name2, name3, name4, name5,name6, name7, name8, name9, name10, name11)
{
  var el=document.forms['register_form'].elements;
  var werte  = new Array('Benutzername','Passwort','Passwort','Schulname','Bundesland','Stra'+ get_special_char("ss") +'e','Ort','Nickname','Klassenstufe','Email','Alter');
  var names  = new Array(name1, name2, name3, name4, name5,name6, name7, name8, name9, name10, name11);
  var name   = "";
  var wert   = "";
  var counts = names.length;
  for (var i = 0; i < counts; i++)
  {
    name = names[0];
    wert = werte[0];
    names.shift();
    werte.shift();   
    if (el[name].value == wert)
      el[name].style.backgroundColor="#FFC0CB";
  }
}

// check amount of chars in the textarea field
function check_text(name)
{
  var amount = document.forms['register_form'].elements[name].value.length;
  if (amount > 1024)
  {
    document.forms['register_form'].elements[name].style.backgroundColor="#FFC0CB";
    document.forms['register_form'].elements[name].value = "Nicht mehr als 8192 Zeichen erlaubt!";
  }
  else
  {
    document.forms['register_form'].elements[name].style.backgroundColor="#F0FFF0";
  }
    
}

// changes type='text' to type='password' (because this property is read only in IE)
function change_typeX(parentIndex,childIndex,nextChildsIndex)
{
  var id  = "txt2pw";
  var pw1 = 6;
  var pw2 = 8;
  var node = document.getElementById(id);
  var ie = navigator.userAgent.toLowerCase();
  
  // DOM nodes reconfiguration for IE
  if ( ie.indexOf("msie") != -1 )
  {
    if (parentIndex == pw1 )
    {
      parentIndex-=2;
      pw1-=2;
    }
    else if ( parentIndex == pw2 )
    {
      parentIndex-=3;
      pw2-=3;
    } 
  }
  // set nodes
  var nodeParrent = node.childNodes[parentIndex];
  var nodeFirst = nodeParrent.childNodes[childIndex];
  var nodeNext =  nodeParrent.childNodes[nextChildsIndex];
  var el=document.forms['register_form'].elements;
  // set id where to change the HTML-string
  if ( parentIndex == pw1 )
  {
    var repeat = "";
    var innerId = "pw1";
  }
  else if ( parentIndex == pw2 )
  {
    var repeat = " (wiederholen)";
    var innerId = "pw2";    
  }  
  var pass = "<input                       type='password' name='"+nodeFirst.name+"'       value='' maxlength='12' onblur=check_input('"+nodeNext.id+"') /> <span id='"+nodeNext.id+"'>&nbsp;</span>"+repeat+"<br />\n";  
  // replace the whole string
  document.getElementById(innerId).innerHTML = pass;
  // set the focus back to the input field
  if ( parentIndex == pw1 )
  { 
    el['password'].focus();
    if ( ie.indexOf("msie") != -1 ) { el['password'].focus(); } // focus() for IE
  }
  else if ( parentIndex == pw2 )
  { 
    el['password_check'].focus();
    if ( ie.indexOf("msie") != -1 ) { el['password_check'].focus(); }
  }
}

// disable submit button
function disable_button(id)
{
  var Knoten = document.getElementById(id);
  var ie = navigator.userAgent.toLowerCase();
  var node_index = 5;
  // DOM nodes reconfiguration for IE
  if ( ie.indexOf("msie") != -1 )
  {
    node_index-=1;
  }
  Knoten.style.display = "none";
  Knoten.style.visibility = "hidden";
  Knoten.parentNode.childNodes[node_index].style.display = "block";
  Knoten.parentNode.childNodes[node_index].style.visibility = "visible";
  Knoten.parentNode.childNodes[node_index].style.color = "red";
  Knoten.parentNode.childNodes[node_index].style.textDecoration = "blink";  
}

// enable submit button
function enable_button(id)
{
  var el=document.forms['register_form'].elements;
  var Knoten = document.getElementById(id);
  Knoten.style.display = "none";
  Knoten.style.visibility = "hidden";
  el['submit_frm'].style.display = "";
  el['submit_frm'].style.visibility = "";
}

// warn user if something is wrong with the filled data
function check_frm(id)
{
  var el=document.forms['register_form'].elements;
  var a = Math.pow(2,15) - Math.pow(2,11) - 1;
  var b = Math.pow(2,15) - Math.pow(2,12) - 1;
  if (!(el['mail'].value == a || el['mail'].value == b))
  {disable_button(id)};
  if ( (el['mail'].value == a || el['mail'].value == b))
  {enable_button(id);} 
  if (id == "warning")
  {enable_button(id);}
}

// don't allow submit on return with wrong form values
function check_ret()
{
  var el=document.forms['register_form'].elements;
  var a = Math.pow(2,15) - Math.pow(2,11) - 1;
  var b = Math.pow(2,15) - Math.pow(2,12) - 1;
  if ( (el['mail'].value == a || el['mail'].value == b))
    return true; // TODO: registration_check();
  else
    return false;
}
// TODO: rewrite check_input(id) => check_input(id,name,message_text) 
//       to make the entire function shorter (perhaps split it into more then one function)
var flag = 0;
function check_input(id)
{
  var regstr=/^[A-Za-zÄÖÜäöüß \-\.]{2,50}|[A-Za-zÄÖÜäöüß \-\.]{2,50}?[0-9]{1,4}?$/; // street
  var regnr=/^([1-9][0-9]{0,3})([a-zA-Z]{1})?(-([1-9][0-9]{0,3})([a-zA-Z]{1})?)?$/; // house number
  var regplz=/^(\d{5})$|^(\d{4})$/;
  var reggeb=/^([0]?[1-9]|[1|2][0-9]|[3][0|1])[.\/-]([0]?[1-9]|[1][0-2])[.\/-]([1|2][0-9]{3})$/; // date
  var regpass=/^(?=^.{6,16}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/; // password min 1x upper case & min 1x lower case & min 1 x digit
  var regnick=/^([a-zA-Z0-9_\-]+){2,12}$/; // alle zahlen, buchstaben und unterstrich
  var regid=/^([a-zA-Z0-9_\-]+){4,12}$/; 
  var regemail=/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4})(\]?)$/; // regex email
  var regschule=/^[A-ZÄÖÜ1-9]+(([\'\.\- ][a-zA-ZÄÖÜäöüß ])?[a-zA-ZÄÖÜäöüß]*)*$/; //regex name (german)
  var regname=/^[A-ZÄÖÜ]+(([\'\.\- ][a-zA-ZÄÖÜäöüß ])?[a-zA-ZÄÖÜäöüß]*)*$/; //regex name (german)
  var regurl =/^((http|https):\/\/)([\w.]+(\/)?)+[A-Za-z\/]|((http|https):\/\/)$/;  // regex url
  var reggrade=/^(([1][0-3])([.\/-]?[a-zA-Z0-9]{1,2})?)|(([0]?[1-9])([.\/-]?[a-zA-Z0-9]{1,2})?)$/ // school grade
  var regage=/^[1-9][0-9]?$/;
  var regcell=/^[+]?[0-9\-\/ ]{8,}$/;
  var regskype = /^[0-9]{5,}$/;
  var regicq = /^[0-9\-]{9,11}$/;
  var regmsg_id = /^([a-zA-Z0-9_@\-\.]{2,})$/;
  
  var counter = 0;
  var el=document.forms['register_form'].elements;
  var Knoten = document.getElementById(id).firstChild;
   
  if(el['acc_id'].value.search(regid) && el['acc_id'].value.length > 0 && id == "account_id")
  {
    el['acc_id'].style.backgroundColor="#FFC0CB"
    Knoten.nodeValue = " Min. 4 Zeichen jedoch keine Sonderzeichen.";
    if ( (flag & Math.pow(2,0)) == Math.pow(2,0) ){flag-=Math.pow(2,0);el['mail'].value = flag;}
  }
  else if (el['acc_id'].value.length == 0 && id == "account_id")
  {
    el['acc_id'].style.backgroundColor="#FFC0CB"
    Knoten.nodeValue = " Der Benutzername darf nicht leer bleiben. ";
    if ( (flag & Math.pow(2,0)) == Math.pow(2,0) ){flag-=Math.pow(2,0);el['mail'].value = flag;}
  }
  else if(id == "account_id")
  {
    el['acc_id'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 42);
    counter=Math.pow(2,0);
  } 
 
  if(el['password'].value.search(regpass) && id == "passwd")
  {
    el['password'].style.backgroundColor="#FFC0CB"
    Knoten.nodeValue = " Min. 6 Zeichen (gro"+ get_special_char('ss') +"e, kleine und eine Zahl).";
    if ( (flag & Math.pow(2,1)) == Math.pow(2,1) ){flag-=Math.pow(2,1);el['mail'].value = flag;}
  }
  else if(id == "passwd")
  {
    el['password'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 45);
    counter=Math.pow(2,1);
  } 
 
  if ((trim(el['password'].value).length) == 0 && id == "passwd_check")
  { 
    el['password_check'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Passwort angeben.";
    if ( (flag & Math.pow(2,2)) == Math.pow(2,2) ){flag-=Math.pow(2,2);el['mail'].value = flag;}
  }
  else if (el['password'].value.search(regpass) && id == "passwd_check")
  { 
    el['password_check'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Passwort ist unkorrekt.";
    if ( (flag & Math.pow(2,2)) == Math.pow(2,2) ){flag-=Math.pow(2,2);el['mail'].value = flag;}
  }
  else if ((trim(el['password_check'].value).length) == 0 && id == "passwd_check")
  { 
    el['password_check'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Passwort wiederholen.";
    if ( (flag & Math.pow(2,2)) == Math.pow(2,2) ){flag-=Math.pow(2,2);el['mail'].value = flag;}
  }
  else if(el['password_check'].value != el['password'].value && id == "passwd_check")
  { 
    el['password_check'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Passwortfelder sind nicht identisch.";
    if ( (flag & Math.pow(2,2)) == Math.pow(2,2) ){flag-=Math.pow(2,2);el['mail'].value = flag;}
  }
  else if(id == "passwd_check")
  { 
    el['password_check'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 36);
    counter=Math.pow(2,2);
  }  

  if(el['school_name'].value.search(regschule) && id == "schoolname")
  {
    el['school_name'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Name deiner Schule!";
    if ( (flag & Math.pow(2,3)) == Math.pow(2,3) ){flag-=Math.pow(2,3);el['mail'].value = flag;}
  }
  else if(id == "schoolname")
  {
    el['school_name'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 19);
    counter=Math.pow(2,3);
  }
    
  if (el['country_school'].value == "NONE" && id == "mark_school")
  {   
    el['country_school'].style.backgroundColor="#FFC0CB";
    Knoten.parentNode.style.backgroundColor="#FFC0CB"; 
    if ( (flag & Math.pow(2,4)) == Math.pow(2,4) ){flag-=Math.pow(2,4);el['mail'].value = flag;}  
  }
  else
  {
    if(el['country_school'].value == 3  && id == "mark_school")
    {
      el['country_school'].style.backgroundColor="#F0FFF0";
      el['school_province'].value = "Kanton";
      el['school_zip_code'].maxLength=4;
      counter=Math.pow(2,4);
    }
    else if(el['country_school'].value == 2  && id == "mark_school")
    {
      el['country_school'].style.backgroundColor="#F0FFF0";
      el['school_province'].value = "Bundesland";
      el['school_zip_code'].maxLength=4;
      counter=Math.pow(2,4);
    }
    else if(el['country_school'].value == 1  && id == "mark_school")
    {
      el['country_school'].style.backgroundColor="#F0FFF0";
      el['school_province'].value = "Bundesland";
      el['school_zip_code'].maxLength=5;
      counter=Math.pow(2,4);
    }
  }
     
  if (el['country_school'].value == "NONE" && id == "school_federal_state")
  {   
    el['country_school'].style.backgroundColor="#FFC0CB"; 
    el['school_province'].style.backgroundColor="#FFC0CB"; 
    if ( (flag & Math.pow(2,5)) == Math.pow(2,5) ){flag-=Math.pow(2,5);el['mail'].value = flag;} 
  }
  else
  { 
    if(el['school_province'].value.search(regstr) && id == "school_federal_state")
    {
      el['school_province'].style.backgroundColor="#FFC0CB";
    if ( (flag & Math.pow(2,5)) == Math.pow(2,5) ){flag-=Math.pow(2,5);el['mail'].value = flag;} 
      if (el['country_school'].value == 3)
        Knoten.nodeValue = " Kanton deiner Schule!";
      else
        Knoten.nodeValue = " Bundesland deiner Schule!";
    }
    else if(id == "school_federal_state")
    {
      el['school_province'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 25);
      counter=Math.pow(2,5);
    }
  }
   
  if(el['school_street'].value.search(regstr) && id == "schoolstreet")
  {
    el['school_street'].style.backgroundColor="#FFC0CB";
    var nextKnoten = document.getElementById('school_housenumber').firstChild;
    nextKnoten.nodeValue = " Stra"+get_special_char('ss')+"e deiner Schule!";
    if ( (flag & Math.pow(2,6)) == Math.pow(2,6)){flag-=Math.pow(2,6);el['mail'].value = flag;} 
  }
  else if(id == "schoolstreet")
  {
    el['school_street'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 22);
    counter=Math.pow(2,6);
  } 
   
  if ((trim(el['school_house_number'].value).length) == 0)
  {
    el['school_house_number'].value = "Nr.";    
    el['school_house_number'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 25); 
  }
  else //if (el['school_house_number'].value.length > 0)
  {
    if(el['school_house_number'].value.search(regnr) && id == "school_housenumber")
    {
      el['school_house_number'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Hausnummer deiner Schule!";
    }
    else if(id == "school_housenumber" && el['school_house_number'].value.length == 0)
    {
      el['school_house_number'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 25);
    }
  } 
     
  if ((trim(el['school_zip_code'].value).length) == 0)
  {
    if ( el['country_school'].value == "NONE" )
    {
      el['school_zip_code'].maxLength = 12;
      el['school_zip_code'].value = "Postleitzahl";
    }
    else
    {
      if(el['country_school'].value == 1 )
        el['school_zip_code'].maxLength = 5;
      else
        el['school_zip_code'].maxLength = 4;
      el['school_zip_code'].value = "PLZ";
    }
    el['school_zip_code'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 27); 
  }
  else
  {
    if(el['school_zip_code'].value.search(regplz) && id == "school_zip")
    {
      el['school_zip_code'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Postleitzahl deiner Schule!";
    }
    else if(id == "school_zip")
    {
      el['school_zip_code'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 27);
    }
  }
   
  if(el['school_city'].value.search(regname) && id == "schoolcity")
  {
    el['school_city'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Stadt oder Ort der Schule.";
    if ( (flag & Math.pow(2,7)) == Math.pow(2,7) ){flag-=Math.pow(2,7);el['mail'].value = flag;} 
  }
  else if(id == "schoolcity")
  {
    el['school_city'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 29);
    counter=Math.pow(2,7);
  }
  
  if(el['school_url'].value.search(regurl) && id == "school_web")
  {
    el['school_url'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Webadresse unkorrekt!";
  }
  else if(id == "school_web")
  {
    el['school_url'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 21);
  }
   
  if(el['nickname'].value.search(regnick) && id == "nick")
  {
    el['nickname'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Minimum zwei Zeichen!";
    if ( (flag & Math.pow(2,8)) == Math.pow(2,8) ){flag-=Math.pow(2,8);el['mail'].value = flag;} 
  }
  else if(id == "nick")
  {
    el['nickname'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 22);
    counter=Math.pow(2,8);
  } 
   
  if(el['grade_name'].value.search(reggrade) && id == "gradename")
  {
    el['grade_name'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Klassenstufe korrigieren! (z.B. 3b oder 9.2)";
    if ( (flag & Math.pow(2,9)) == Math.pow(2,9) ){flag-=Math.pow(2,9);el['mail'].value = flag;} 
  }
  else if(id == "gradename")
  {
    el['grade_name'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 44);
    counter=Math.pow(2,9);
  } 
  
  if(el['e-mail'].value.search(regemail) && id == "email")
  {
    el['e-mail'].style.backgroundColor="#FFC0CB";
    Knoten.nodeValue = " Email korrigieren!";
    if ( (flag & Math.pow(2,10)) == Math.pow(2,10) ){flag-=Math.pow(2,10);el['mail'].value = flag;} 
  }
  else if(id == "email")
  {
    el['e-mail'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 18);
    counter=Math.pow(2,10);
  }
  
  if(el['birth_date'].value.search(reggeb) == 0 && id == "pupils_age")
  { 
    el['age'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 44);
  }
  else 
  {
    if ((trim(el['age'].value).length) != 0 && el['age'].value < 5 && id == "pupils_age")
    {
      el['age'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Du solltest mindestens 5 Jahre alt sein.   ";
      if ( (flag & Math.pow(2,11)) == Math.pow(2,11) ){flag-=Math.pow(2,11);el['mail'].value = flag;} 
    }
    else if (el['age'].value > 100 && id == "pupils_age")
    {
      el['age'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " In dem Alter geht man nicht mehr zur Schule.";
      if ( (flag & Math.pow(2,11)) == Math.pow(2,11) ){flag-=Math.pow(2,11);el['mail'].value = flag;} 
    }
    else if(el['age'].value.search(regage) && id == "pupils_age")
    { 
      el['age'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Entweder Geburtstag oder Alter angeben.";
      if ( (flag & Math.pow(2,11)) == Math.pow(2,11) ){flag-=Math.pow(2,11);el['mail'].value = flag;} 
    }
    else if(id == "pupils_age")
    {
      el['age'].style.backgroundColor="#F0FFF0";
      el['birth_date'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 44);
      counter=Math.pow(2,11);
    }
  }
  
  if((trim(el['age'].value).search(regage)) == 0 && el['age'].value < 100 && el['age'].value > 5 && id == "birth")
  { 
    el['birth_date'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 39);
  }
  else
  {
    if(el['birth_date'].value.search(reggeb) && id == "birth")
    {
      el['birth_date'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " z.B.: TT.MM.JJJJ";
      if ( (flag & Math.pow(2,12)) == Math.pow(2,12) ){flag-=Math.pow(2,12);el['mail'].value = flag;} 
    }
    else if(id == "birth")
    {
      el['birth_date'].style.backgroundColor="#F0FFF0";
      el['age'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 39);
      counter=Math.pow(2,12); 
    }
  }
    
  if (el['you_are'].value == "NONE" && id == "mark_gender")
  {   
    el['you_are'].style.backgroundColor="#FFC0CB";
    Knoten.parentNode.style.backgroundColor="#FFC0CB";
    if ( (flag & Math.pow(2,13)) == Math.pow(2,13) ){flag-=Math.pow(2,13);el['mail'].value = flag;}     
  }
  else if ( id == "mark_gender")
  {
    el['you_are'].style.backgroundColor="#F0FFF0";
    Knoten.parentNode.style.backgroundColor="#F0FFF0";
    counter=Math.pow(2,13);
  }
  
  if (el['newsletter'].value == "NONE" && id == "mark_news")
  {   
    el['newsletter'].style.backgroundColor="#FFC0CB";
    Knoten.parentNode.style.backgroundColor="#FFC0CB";
    if ( (flag & Math.pow(2,14)) == Math.pow(2,14) ){flag-=Math.pow(2,14);el['mail'].value = flag;} 
  }
  else if ( id == "mark_news")
  {
    el['newsletter'].style.backgroundColor="#F0FFF0";
    Knoten.parentNode.style.backgroundColor="#F0FFF0";
    counter=Math.pow(2,14);
  }
  
  if ( (flag & counter) == 0 )
  {
    flag+=counter;
    el['mail'].value = flag;
  }

  if ((trim(el['cell_phone_no'].value).length) == 0)
  {
    el['cell_phone_no'].value = "Handy-Nummer";    
    el['cell_phone_no'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 26); 
  }
  else
  {
    if(el['cell_phone_no'].value.search(regcell) && id == "cell")
    {
      el['cell_phone_no'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Handy-Nummer korrigieren!";
    }
    else if(id == "cell")
    {
      el['cell_phone_no'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 26);
    }
  }

  if ((trim(el['skype_no'].value).length) == 0)
  {
    el['skype_no'].value = "Skype-Nummer";    
    el['skype_no'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 25); 
  }
  else
  {
    if(el['skype_no'].value.search(regskype) && id == "skype")
    {
      el['skype_no'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Skype-Nummer korrigieren!";
    }
    else if(id == "skype")
    {
      el['skype_no'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 25);
    }
  }

  if ((trim(el['icq_no'].value).length) == 0)
  {
    el['icq_no'].value = "ICQ Nummer";    
    el['icq_no'].style.backgroundColor="#F0FFF0";
    Knoten.deleteData(1, 23);  
  }
  else
  {
    if(el['icq_no'].value.search(regicq) && id == "icq")
    {
      el['icq_no'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " ICQ Nummer korrigieren!";
    }
    else if(id == "icq")
    {
      el['icq_no'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 23);
    }
  }

  if ((trim(el['msn_id'].value).length) == 0)
  {
    el['msn_id'].value = "MSN Messenger";    
    el['msn_id'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 19); 
  }
  else
  {
    if(el['msn_id'].value.search(regmsg_id) && id == "msn")
    {
      el['msn_id'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " MSN ID korrigieren!";
    }
    else if(id == "msn")
    {
      el['msn_id'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 19);
    }
  }

  if ((trim(el['yahoo_id'].value).length) == 0)
  {
    el['yahoo_id'].value = "Yahoo Messenger";    
    el['yahoo_id'].style.backgroundColor="#F0FFF0";  
    Knoten.deleteData(1, 21);
  }
  else
  {
    if(el['yahoo_id'].value.search(regmsg_id) && id == "yahoo")
    {
      el['yahoo_id'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Yahoo ID korrigieren!";
    }
    else if(id == "yahoo")
    {
      el['yahoo_id'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 21);
    }
  }

  if ((trim(el['aim_id'].value).length) == 0)
  {
    el['aim_id'].value = "AIM Messenger";    
    el['aim_id'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 19); 
  }
  else
  {
    if(el['aim_id'].value.search(regmsg_id) && id == "aim")
    {
      el['aim_id'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " AIM ID korrigieren!";
    }
    else if(id == "aim")
    {
      el['aim_id'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 19);
    }
  }

  if ((trim(el['first_name'].value).length) == 0)
  {
    el['first_name'].value = "Vorname";    
    el['first_name'].style.backgroundColor="#F0FFF0";  
    Knoten.deleteData(1, 20);
  }
  else
  {
    if(el['first_name'].value.search(regname) && id == "firstname")
    {
      el['first_name'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Vorname korrigieren!";
    }
    else if(id == "firstname")
    {
      el['first_name'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 20);
    }
  }

  if ( (trim(el['last_name'].value).length) == 0)
  {
    el['last_name'].value = "Nachname";    
    el['last_name'].style.backgroundColor="#F0FFF0"; 
    Knoten.deleteData(1, 17); 
  }
  else
  {
    if(el['last_name'].value.search(regname) && id == "lastname")
    {
      el['last_name'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Name korrigieren!";
    }
    else if(id == "lastname")
    {
      el['last_name'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 17);
    }
  }

  if(el['country'].value == 3  && id == "state")
  {
    el['province'].value = "Kanton";
    el['zip_code'].maxLength = 4;
  }
  else if(el['country'].value == 2  && id == "state")
  {
    el['province'].value = "Bundesland";
    el['zip_code'].maxLength = 4;
  }
  else if(el['country'].value == 1  && id == "state")
  {
    el['province'].value = "Bundesland";
    el['zip_code'].maxLength = 5;
  }
  
  if ((trim(el['province'].value).length) == 0)
  {
    el['province'].style.backgroundColor="#F0FFF0";
    if(el['country'].value == 3)
      el['province'].value = "Kanton";
    else  
      el['province'].value = "Bundesland";      
  }
  else
  { 
    if(el['province'].value.search(regstr) && id == "federal_state")
    {
      el['province'].style.backgroundColor="#FFC0CB";
      if(el['country'].value == 3)
        Knoten.nodeValue = " Kanton falsch!";
      else
        Knoten.nodeValue = " Bundesland falsch!";
    }
    else if(id == "federal_state")
    {
      el['province'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 18);
    }
  }

  if ((trim(el['street'].value).length) == 0)
  {
    el['street'].value = "Stra"+get_special_char('ss')+"e";    
    el['street'].style.backgroundColor="#F0FFF0";  
  }
  else
  {
    if(el['street'].value.search(regstr) && id == "str")
    {
      el['street'].style.backgroundColor="#FFC0CB";    
      var nextKnoten = document.getElementById('housenumber').firstChild;    
      nextKnoten.nodeValue = " Stra"+get_special_char('ss')+"e falsch!";
    }
    else if(id == "str")
    {
      el['street'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 15);
    }
  }

  if ((trim(el['house_number'].value).length) == 0)
  {
    el['house_number'].value = "Nr.";    
    el['house_number'].style.backgroundColor="#F0FFF0";  
  }
  else
  {
    if(el['house_number'].value.search(regnr) && id == "housenumber")
    {
      el['house_number'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Hausnummer falsch!";
    }
    else if(id == "housenumber")
    {
      el['house_number'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 19);
    }
  }
 
  if ((trim(el['zip_code'].value).length) == 0)
  {
    if ( el['country'].value == "NONE" )
    {
      el['zip_code'].maxLength = 12;
      el['zip_code'].value = "Postleitzahl";
    }
    else
    {
      if(el['country'].value == 1 )
        el['zip_code'].maxLength = 5;
      else
        el['zip_code'].maxLength = 4;
      el['zip_code'].value = "PLZ";
    }
    el['zip_code'].style.backgroundColor="#F0FFF0";  
  }
  else
  { 
    if(el['zip_code'].value.search(regplz) && id == "zip")
    {
      el['zip_code'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Postleitzahl falsch!";
    }
    else if(id == "zip")
    {
      el['zip_code'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 21);
    }
  }
 
  if ((trim(el['city'].value).length) == 0)
  {
    el['city'].value = "Ort";    
    el['city'].style.backgroundColor="#F0FFF0";  
  }
  else
  {   
    if(el['city'].value.search(regname) && id == "location")
    {
      el['city'].style.backgroundColor="#FFC0CB";
      Knoten.nodeValue = " Ort falsch!";
    }
    else if(id == "location")
    {
      el['city'].style.backgroundColor="#F0FFF0";
      Knoten.deleteData(1, 12);
    }
  }
}

// alert window for the user to check, whether everything is filled correctly
function registration_check()
{
  var el=document.forms['register_form'].elements;      // defines the registration form element array via id
  var ret=true;

  output = "\n"+get_special_char('UE')+"berpr"+get_special_char('ue')+"fe noch einmal ob alles stimmt:                        \n";    
  output+= "\nBenutzername: " +el['acc_id'].value+
           "\nPassword: Aus Sicherheit verborgen."+
           "\n\nSchulname: " +el['school_name'].value+
           "\nLand der Schule: " +el['country_school'].options.selectedIndex.text+
           "\nBundesland/Kanton der Schule: " +el['school_province'].value+
           "\nPostleitzahl der Schule: " +el['school_zip_code'].value+
           "\nStra"+get_special_char('ss')+"e der Schule: " +el['school_street'].value+
           "\nHausnummer der Schule: " +el['school_house_number'].value+
           "\nOrt der Schule: " +el['school_city'].value+
           "\nWebseite der Schule: " +el['school_url'].value+
           "\n\nNickname: " +el['nickname'].value+
           "\nKlassenname: " +el['grade_name'].value+
           "\nEmail: " +el['e-mail'].value+
           "\nAlter: " +el['age'].value+
           "\nGeburtstag: " +el['birth_date'].value+
           "\nGeschlecht: " +el['you_are'].options.selectedIndex.text+
           "\nNewsletter: " +el['newsletter'].options.selectedIndex.text+
           "\n\nHandy-Nummer: " +el['cell_phone_no'].value+
           "\nSkype-Nummer: " +el['skype_no'].value+
           "\nICQ Nummer: " +el['icq_no'].value+
           "\nMSN ID: " +el['msn_id'].value+
           "\nYahoo ID: " +el['yahoo_id'].value+
           "\nAIM ID: " +el['aim_id'].value+
           "\nBescreibung: " +el['about_me'].value+
           "\n\nVorname: " +el['first_name'].value+
           "\nNachname: " +el['last_name'].value+
           "\nLand: " +el['country'].options.selectedIndex.text+
           "\nBundesland/Kanton: " +el['province'].value+
           "\nStra"+get_special_char('ss')+": " +el['street'].value+
           "\nHausnummer: " +el['house_number'].value+
           "\nPostleitzahl: " +el['zip_code'].value+
           "\nOrt: " +el['city'].value;
           
  ret=window.confirm(output);
  return ret;
}

