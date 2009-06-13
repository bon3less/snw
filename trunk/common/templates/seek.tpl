          <form method="post" action="search.php" onsubmit="return false;">
            <div>
              <input size="15" name="words" id="words" value="Suchen" type="text" onfocus="val_check(this.id);" onblur="val_check(this.id);" />
              <span><input name="go" value="&#x2729;" type="submit" /></span>
              <input name="page" value={PAGE} type="hidden" />
             </div>
          </form>