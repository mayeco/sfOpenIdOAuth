<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <? if ($sf_user->isAuthenticated()): ?> 
      user_id: <?php echo $sf_user->getAttribute('user_id', '', 'sfGuardSecurityUser') ?> - 
      <?php echo link_to('logout', '@sf_guard_signout') ?>
      <br/>
    <?php endif ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <b><?php echo $sf_user->getFlash('error') ?></b><br/>
    <?php endif ?>
    <?php if ($sf_user->hasFlash('info')): ?>
      <?php echo $sf_user->getFlash('info') ?><br/>
    <?php endif ?>
    <?php echo $sf_content ?>
  </body>
</html>
