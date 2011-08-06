<?php if ($sf_user->isAuthenticated()): ?>
  service connected:
  <?php foreach($oauths as $oauth): ?>
    <?php echo $oauth->name; ?>.com, 
  <?php endforeach; ?>
  <?php foreach($openid as $openid): ?>
    <?php echo $openid->name; ?>, 
  <?php endforeach; ?>
  <br/>
  Add another login service:<br/>
<?php else: ?> 
  Login or sign up using:<br/>
<?php endif; ?>

<?php echo link_to('Facebook', '@default?module=index&action=login&service=facebook&type=oauth', array('class' => 'oauth')) ?> | 
<?php echo link_to('Twitter', '@default?module=index&action=login&service=twitter&type=oauth', array('class' => 'oauth')) ?> | 
<?php echo link_to('Google', '@default?module=index&action=login&service=google&type=openid', array('class' => 'openid')) ?> | 
<?php echo link_to('Yahoo', '@default?module=index&action=login&service=yahoo&type=openid', array('class' => 'openid')) ?> | 
<?php echo link_to('MyOpenid', '@default?module=index&action=login&service=myopenid&type=openid', array('class' => 'openid')) ?>
<br/>
<small><?php echo link_to('more openid', '@homepage', array('id' => 'openid')) ?></small>
<div id="openidform" style="display:none;">
  <form method="post" action="<?php echo url_for('@default?module=index&action=login&service=identity&type=openid') ?>" />
    <input type="text" name="identity" placeholder="Login using OpenID"/>
    <input type="submit" name="submit" value="Log in"/>
  </form>
</div>

<script>
  $(document).ready(function(){
    $("#openid").click(function(event){
      $("#openidform").toggle();
      event.preventDefault();
    });
    $(".oauth").click(function(event){
      $("#openidform").hide();
    });
  });
</script>