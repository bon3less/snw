      <div id="login_front">
        <form id="loginform" action="/common/login_post.php" method="post">
          <fieldset><legend>Login</legend>
            <label for="acc_id">Benutzername</label><br />
            <input name="acc_id" type="text" id="acc_id" maxlength="12" class="button" />
            <br /><br />
            <label for="acc_passwd">Passwort</label><br />
            <input name="acc_passwd" type="password" id="acc_passwd" maxlength="8" class="button" />
            <br /><br />
            <label for="acc_verification1">Validation Code:</label><br />
            <img src="./../../bots/1/captcha.php" id="acc_verification1" alt="validation code" />
            <br /><br />
            <label for="acc_veri">Sicherheitscode:</label><br />
            <input class="button" name="acc_veri" type="text" id="acc_veri" maxlength="8" />
            <p>&nbsp;</p>
            <span><input class="button1" onclick="window.location.href='JavaScript:location.reload(true)'" type="button" name="Refresh" value="Refresh" /></span>
            <span><input class="button1" type="submit" name="submit"  value="Login" /></span>
          </fieldset>
        </form>
      </div>