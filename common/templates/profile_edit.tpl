      <div id="registration" onclick="mark_select('mark_school','mark_gender','mark_news');mark_mandatory('acc_id', 'password', 'password_check', 'school_name', 'school_province','school_street', 'school_city', 'nickname', 'grade_name', 'e-mail', 'age');check_frm('warning');" onkeydown="check_frm('warning');" >
        <div id="reg">
          <h2>{CONTENT_CAPTION}</h2>
          <p>{CONTENT_TEXT}</p><br />
          <form  method="post" action="create_account.php" id="register_form" onsubmit="return check_ret();">
            <fieldset><legend>Deine Login Daten</legend>
              <div id="txt2pw">
                <input class="reg_frm_first" type="text" name="acc_id"         value="Benutzername" maxlength="16" onfocus="this.value='';"       onblur="check_input('account_id');" />   <span id="account_id">&nbsp;</span><br />
                <div id="pw1"><input         type="text" name="password"       value="Passwort"     maxlength="12" onfocus="change_typeX(6,0,2);" onblur="check_input('passwd');" />       <span id="passwd">&nbsp;</span><br /></div>
                <div id="pw2"><input         type="text" name="password_check" value="Passwort"     maxlength="12" onfocus="change_typeX(8,0,2);" onblur="check_input('passwd_check');" /> <span id="passwd_check">&nbsp;</span> (wiederholen)<br /></div>
              </div>
            </fieldset>
            <fieldset><legend>Angaben &uuml;ber deine Schule</legend>
              <div>
                <input class="reg_frm_first" type="text" name="school_name"         value="Schulname"     size="45" maxlength="45" onfocus="this.value='';" onblur="check_input('schoolname');" />         <span id="schoolname">&nbsp;</span><br />
              </div>
              <div>
                <select id="state_school" name="country_school" size="1" onchange="check_input('mark_school');">
                   <option id="mark_school" class="wrong_input" value="NONE">Land ausw&auml;hlen</option>
                   <option                                      value="1">Deutschland</option>
                   <option                                      value="2">&Ouml;sterreich</option>
                   <option                                      value="3">Schweiz</option>
                 </select><br />
              </div>
              <div>
                <input                       type="text" name="school_province"     value="Bundesland"    size="45" maxlength="60" onfocus="this.value='';" onblur="check_input('school_federal_state');"/> <span id="school_federal_state">&nbsp;</span><br />
                <input                       type="text" name="school_zip_code"     value="Postleitzahl"  size="45" maxlength="12" onfocus="this.value='';" onblur="check_input('school_zip');" />         <span id="school_zip">&nbsp;</span><br />
                <input                       type="text" name="school_street"       value="Stra&szlig;e"  size="35" maxlength="45" onfocus="this.value='';" onblur="check_input('schoolstreet');" />       <span id="schoolstreet">&nbsp;</span>
                <input                       type="text" name="school_house_number" value="Nr."           size="5"  maxlength="12" onfocus="this.value='';" onblur="check_input('school_housenumber');" /> <span id="school_housenumber">&nbsp;</span><br />
                <input                       type="text" name="school_city"         value="Ort"           size="45" maxlength="45" onfocus="this.value='';" onblur="check_input('schoolcity');" />         <span id="schoolcity">&nbsp;</span><br />
              </div>
              <div>
                <input type="text" name="school_url"   value="Webseite" size="45" maxlength="80" onfocus="this.value='http://';" onblur="check_input('school_web');" /><span id="school_web">&nbsp;</span><br />
              </div>
            </fieldset>
            <fieldset><legend>Deine Profil Infos</legend>
              <div>
                <input class="reg_frm_first" type="text" name="nickname"   value="Nickname"     size="27" maxlength="16" onfocus="this.value='';" onblur="check_input('nick');" /><span id="nick">&nbsp;</span><br />
                <input                       type="text" name="grade_name" value="Klassenstufe" size="27" maxlength="45" onfocus="this.value='';" onblur="check_input('gradename');" /><span id="gradename">&nbsp;</span><br />
                <input                       type="text" name="e-mail"     value="Email"        size="27" maxlength="45" onfocus="this.value='';" onblur="check_input('email');" /><span id="email">&nbsp;</span><br />
                <input                       type="text" name="age"        value="Alter"        size="27" maxlength="45" onfocus="this.value='';" onblur="check_input('pupils_age');" /><span id="pupils_age">&nbsp;</span><br />
                <input                       type="text" name="birth_date" value="Geburtstag"   size="27" maxlength="10" onfocus="this.value='';" onblur="check_input('birth');" /><span id="birth">&nbsp;</span><br />
              </div>
              <div>
                 <select id="gender" name="you_are" size="1" onchange="check_input('mark_gender');">
                   <option id="mark_gender" class="wrong_input" value="NONE"> - Du bist? - </option>
                   <option                                      value="male">m&auml;nnlich</option>
                   <option                                      value="female">weiblich</option>
                 </select><br />
              </div>
              <div class="">
                <select id="news_letter" name="newsletter" size="1" onchange="check_input('mark_news');">
                  <option id="mark_news" class="wrong_input" value="NONE"> Newsletter </option>
                  <option                                    value="1">einschalten</option>
                  <option                                    value="0">ausschalten</option>
                </select>
              </div>
              <div>
                <input class="reg_frm_first" type="text" name="cell_phone_no" value="Handy-Nummer"     size="27" maxlength="15" onfocus="this.value='';" onblur="check_input('cell');" />  <span id="cell">&nbsp;</span><br />
                <input                       type="text" name="skype_no"      value="Skype-Nummer"     size="27" maxlength="15" onfocus="this.value='';" onblur="check_input('skype');" /> <span id="skype">&nbsp;</span><br />
                <input                       type="text" name="icq_no"        value="ICQ Nummer"       size="27" maxlength="15" onfocus="this.value='';" onblur="check_input('icq');" />   <span id="icq">&nbsp;</span><br />
                <input                       type="text" name="msn_id"        value="MSN Messenger"    size="27" maxlength="60" onfocus="this.value='';" onblur="check_input('msn');" />   <span id="msn">&nbsp;</span><br />
                <input                       type="text" name="yahoo_id"      value="Yahoo Messenger"  size="27" maxlength="60"  onfocus="this.value='';" onblur="check_input('yahoo');" /> <span id="yahoo">&nbsp;</span><br />
                <input                       type="text" name="aim_id"        value="AIM Messenger"    size="27" maxlength="60" onfocus="this.value='';" onblur="check_input('aim');" />   <span id="aim">&nbsp;</span><br />
              </div>
              <div>
                <textarea id="reg_description" class="reg_frm_first" cols="65" rows="6" name="about_me" onfocus="this.value='';" onclick="check_text('about_me');" onkeypress="check_text('about_me');">Hier kannst du dich kurz beschreiben...</textarea><br />
              </div>
              <div class="hideme">
                <label for="mail">&nbsp;</label>
                <input type="hidden" name="mail" id="mail" />
              </div>
            </fieldset>
            <fieldset><legend>Deine pers&ouml;nlichen Angaben (keine Pflichtfelder)</legend>
              <div>
                <input class="reg_frm_first" type="text" name="first_name"   value="Vorname"      size="45" maxlength="45" onfocus="this.value='';" onblur="check_input('firstname');" />        <span id="firstname">&nbsp;</span><br />
                <input                       type="text" name="last_name"    value="Nachname"     size="45" maxlength="45" onfocus="this.value='';" onblur="check_input('lastname');" />         <span id="lastname">&nbsp;</span><br />
              </div>
              <div>
                <select id="state" name="country" size="1" onchange="check_input('state');">
                  <option value="NONE">Land ausw&auml;hlen</option>
                  <option value="1">Deutschland</option>
                  <option value="2">&Ouml;sterreich</option>
                  <option value="3">Schweiz</option>
                </select><br />
              </div>
              <div>
                <input                       type="text" name="province"     value="Bundesland"   size="45" maxlength="60" onfocus="this.value='';" onblur="check_input('federal_state');"/>     <span id="federal_state">&nbsp;</span><br />
                <input                       type="text" name="street"       value="Stra&szlig;e" size="35" maxlength="80" onfocus="this.value='';" onblur="check_input('str');" />              <span id="str">&nbsp;</span>
                <input                       type="text" name="house_number" value="Nr."          size="5"  maxlength="12" onfocus="this.value='';" onblur="check_input('housenumber');" />      <span id="housenumber">&nbsp;</span><br />
                <input                       type="text" name="zip_code"     value="Postleitzahl" size="45" maxlength="12" onfocus="this.value='';" onblur="check_input('zip');" />              <span id="zip">&nbsp;</span><br />
                <input                       type="text" name="city"         value="Wohnort"      size="45" maxlength="60" onfocus="this.value='';" onblur="check_input('location');"/>          <span id="location">&nbsp;</span><br />
              </div>
            </fieldset>
            <div id="reg_buttons">
              <input type="reset"  name="reset_frm"  id="resetme"  value="Nochmal eingeben" class="button" />
              <input type="submit" name="submit_frm" id="submitme" value="Jetzt Anmelden" class="button" onmouseover="check_frm('submitme');" />
              <span class="hideme" id="warning" >Formular korrekt ausf&uuml;llen!</span>
            </div>
          </form>
        </div>
      </div>
