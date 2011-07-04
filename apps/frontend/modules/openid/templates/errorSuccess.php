<?php if ($sf_user->hasFlash('openid_error')): ?>
  <div><?php echo $sf_user->getFlash('openid_error') ?></div>
<?php endif ?>