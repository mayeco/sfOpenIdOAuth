<?php

/**
 * index actions.
 *
 * @package    sfOpenIdOAuth
 * @subpackage index
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class indexActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {

    if($this->getUser()->isAuthenticated() == true){
      $this->oauths = TokenTable::getInstance()
        ->createQuery('t')
        ->where('user_id = ?', $this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser'))
        ->execute();
      $this->openid = IdentityTable::getInstance()
        ->createQuery('t')
        ->where('user_id = ?', $this->getUser()->getAttribute('user_id', '', 'sfGuardSecurityUser'))
        ->execute();
    }
  }

  public function executeFinish(sfWebRequest $request) {
  }

  public function executeRegister(sfWebRequest $request) {

    $this->user = $this->getUser()->getGuardUser();
    $this->forward404Unless($this->user);
    if($this->user->getIsActive() == true){
      $this->redirect('@default?module=index&action=finish');
    }

    $this->getUser()->setFlash('info', 'User not activate please confirm');

    if ($request->isMethod('post')) {

      $username = $request->getParameter('username');
      $email = $request->getParameter('email');
      $this->forward404Unless($username);
      $this->forward404Unless($email);

      $this->user->setUsername($username);
      $this->user->setEmailAddress($email);
      $this->user->setIsActive(true);
      $this->user->save();

      $this->getUser()->setFlash('info', 'User activate');
      $this->redirect('@default?module=index&action=finish');

    }

  }

  public function executeLogin(sfWebRequest $request) {

    $logintype = $request->getParameter('type');
    $service = $request->getParameter('service');
    $this->forward404Unless($logintype);
    $this->forward404Unless($service);

    if($logintype == 'oauth' && ($service == 'twitter' or $service == 'facebook')){
      $this->getUser()->connect($service);
    } else if ($logintype == 'openid') {
      $this->forward('openid', 'verify');
    }

  }

}
