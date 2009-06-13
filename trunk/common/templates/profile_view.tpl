        <div id="outer">
          <div id="profil_header">
            <h3>{USER_NICK}</h3>
          </div>
          <div id="profil_view">
            <div id="profil_top">
              <img src={_PROFILE_IMG} alt={PROFILE_IMG} />
              <div id="profile_right_top">
                <p id="online_status">Status: <span>{ONLINE_STATUS} </span></p>
                <p>Mitglied seit: <span>{MEMBER_SINCE} </span></p>
                <p id="email">Email: <span>{PUPIL_EMAIL} </span></p>
              </div>
              <div id="profile_top_btn">
                <ul>
                  <li><a href={_ADD_FRIEND} title={ADD_FRIEND}>{USER_NICK} zu deinen Freunden hinzuf&uuml;gen</a></li>
                  <li><a href={_SEND_MSG} title={SEND_MSG}>{USER_NICK} eine Nachricht senden</a></li>
                </ul>
              </div>
            </div>
            <div id="profil_middle">
              <div>
                <p>
                  <span>Siehe auch:</span>
                  <a href={_FRIEND_LIST} title={FRIEND_LIST}>Freunde</a>&nbsp;::
                  <a href={_CLASS_MATES} title={CLASS_MATES}>Klassenkameraden</a>&nbsp;::
                  <a href={_VOTE_LIST} title={VOTE_LIST}>Bewertungen</a>&nbsp;::
                  <a href={_FAVORITE_LIST} title={FAVORITE_LIST}>Favoritenliste</a>&nbsp;::
                  <a href={_PICTURE_LIST} title={PICTURE_LIST}>Fotos</a>
                </p>
              </div>
            </div>
            <div id="profil_bottom">
              <p id="profil_land">Land: <span>{SCHOOL_COUNTRY}</span></p>
              <p id="profil_ort">Ort: <span>{SCHOOL_CITY}</span></p>
              <p id="profil_kanton">{KANTON_KIND}: <span>{SCHOOL_BUNDESLAND}</span></p>
              <p id="profil_schule">Schule: <span>{SCHOOL_NAME}</span></p>
              <p id="profil_klasse">Klasse: <span>{GRADE_NAME}</span></p>
              <p id="profil_geschlecht">Geschlecht: <span>{PUPIL_GENDER}</span></p>
<!-- PUPIL_AGE -->
{PUPIL_AGE}
<!-- END PUPIL_AGE -->

<!-- PUPIL_BIRTH -->
{PUPIL_BIRTH}
<!-- END PUPIL_BIRTH -->

<!-- PUPIL_CELL -->
{PUPIL_CELL}
<!-- END PUPIL_CEL -->

<!-- PUPIL_SKYPE -->
{PUPIL_SKYPE}
<!-- END PUPIL_SKYPE -->

<!-- PUPIL_ICQ -->
{PUPIL_ICQ}
<!-- END PUPIL_ICQ -->

<!-- PUPIL_MSN -->
{PUPIL_MSN}
<!-- END PUPIL_MSN -->

<!-- PUPIL_YAHOO -->
{PUPIL_YAHOO}
<!-- END PUPIL_YAHOO -->

<!-- PUPIL_AIM -->
{PUPIL_AIM}
<!-- END PUPIL_AIM -->
              <p id="profil_url">Profil URL: <span>{PUPIL_PROFILE_URL}</span></p>
            </div>
          </div>
        </div>