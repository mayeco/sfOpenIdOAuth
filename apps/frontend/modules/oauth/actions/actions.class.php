<?php

/**
 * oauth actions.
 *
 * @package    sfOpenIdOAuth
 * @subpackage oauth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class oauthActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getUser()->connect('twitter');
  }

  public function executeConnect(sfWebRequest $request) {

  }

  public function executeRegister(sfWebRequest $request) {

    $melody = unserialize($this->getUser()->getAttribute('melody'));

    $access_token = $melody->getToken();
    $user = $melody->getUser();

    if($access_token){

      $user->setUsername($access_token->getIdentifier());
      $user->setEmailAddress($access_token->getIdentifier());

    }

    $user->save();

    if($user) {

      $access_token->setUserId($user->getId());
      if(!$this->getUser()->isAuthenticated()) {
          $this->getUser()->signin($user, sfConfig::get('app_melody_remember_user', true));
      }

    }

    $this->getUser()->addToken($access_token);

  }
  
}
