      <div id="login_front">
        <form id="loginform" action="login.php" method="post" onsubmit="return check_login('login_front');">
          <div>
            <label for="acc_id">Benutzername</label>
            <input name="acc_id" type="text" id="acc_id" maxlength="16" class="button" />
            <label for="acc_passwd">Passwort</label>
            <input name="acc_passwd" type="password" id="acc_passwd" maxlength="12" class="button" />
            <span><input class="button1" type="submit" name="submit"  value="Login" /></span> 
            <input name="page" value={PAGE} type="hidden" />
          </div>
        </form>
      </div>