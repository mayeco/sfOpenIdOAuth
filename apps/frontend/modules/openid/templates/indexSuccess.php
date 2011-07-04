<div class="center">

  <h1>Log in using your OpenID</h1>
  <form method="post" action="<?php echo url_for('openid_verify') ?>" />
  <div class="login_form">
    <input type="text" name="identity" placeholder="Login using OpenID" class="openid_input"/>
    <p><input type="submit" class="button green" name="submit" value="Log in"/></p>
    </form>
  </div>

</div>