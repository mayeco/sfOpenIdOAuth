<form method="post" action="<?php echo url_for('@default?module=index&action=register&code=verify') ?>" />
  username: <input type="text" name="username" /><br/>
  email: <input type="text" name="email" /><br/>
  <input type="submit" name="submit" value="Verify Account"/>
</form>