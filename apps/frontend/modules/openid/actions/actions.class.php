<?php

/**
 * openid actions.
 *
 * @package    sfOpenIdOAuth
 * @subpackage openid
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class openidActions extends BasesfPHPOpenIDAuthActions {

  public function openIDCallback($openid_validation_result) {

    $identity_token = $identity_token = new Identity();
    $identity_token->setIdentifier($openid_validation_result['identity']);
    $user = null;

    if($this->getUser()->isAuthenticated())
    {

      $user = $this->getUser()->getGuardUser();
      $old_identity = IdentityTable::getInstance()->findOneByNameAndIdentifier($openid_validation_result['identity'], $openid_validation_result['identity']);

      if($old_identity && $old_identity->getUser()->getId() != $user->getId()){

        $this->getUser()->signOut();
        //switch to the user with the identity...
        $user = $old_identity->getUser();

      }

    }
    else
    {

      $old_identity = IdentityTable::getInstance()->findOneByNameAndIdentifier($openid_validation_result['identity'], $openid_validation_result['identity']);
      if($old_identity){

        $user = $old_identity->getUser();

      }

      $create_user = sfConfig::get('app_sf_phpopenid_plugin_create_user', false);
      $redirect_register = sfConfig::get('app_sf_phpopenid_plugin_redirect_register', false);

      //create a new user if needed
      if(!$user && ( $create_user || $redirect_register))
      {

        $user = new sfGuardUser();

        if($redirect_register) {

          $this->getUser()->setAttribute('user', serialize($user));
          $this->getUser()->setAttribute('identity_token', serialize($identity_token));
          $this->getUser()->setAttribute('old_identity', serialize($old_identity));

          $this->redirect($redirect_register);

        }
        else {
            $user->save();
        }

      }

    }

    if($user)
    {
      $identity_token->setUserId($user->getId());

      if(!$this->getUser()->isAuthenticated())
      {
        $this->getUser()->signin($user, sfConfig::get('app_sf_phpopenid_plugin_remember_user', true));
      }
    }

    $this->getUser()->addIdentify($identity_token, $old_identity);

  }

  public function executeRegister(sfWebRequest $request) {

    $user = unserialize($this->getUser()->getAttribute('user'));
    $identity_token = unserialize($this->getUser()->getAttribute('identity_token'));
    $old_identity = unserialize($this->getUser()->getAttribute('old_identity'));

    if($user) {

      $user->setUsername($identity_token->getIdentifier());
      $user->setEmailAddress($identity_token->getIdentifier());
      $user->save();

      $identity_token->setUserId($user->getId());

      if(!$this->getUser()->isAuthenticated())
      {
        $this->getUser()->signin($user, true);
      }
    }

    $this->getUser()->addIdentify($identity_token, $old_identity);

  }

  public function executeIndex() {

  }

  public function executeError() {

  }

  public function executeVerify() {

    if($_POST && isset($_POST['identity']) ) {

      $getRedirectHtmlResult = $this->getRedirectHtml($_POST['identity']);

      if ($getRedirectHtmlResult['success']) {
        $this->redirect($getRedirectHtmlResult['url']);
      } else {
        $this->getUser()->setFlash('notice', $getRedirectHtmlResult['error']);
        $this->redirect('@homepage');
      }
    }

  }

}