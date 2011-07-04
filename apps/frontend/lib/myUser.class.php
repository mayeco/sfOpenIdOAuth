<?php

class myUser extends sfMelodyUser
{
  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
    $options['timeout'] = 86400;
    return parent::initialize($dispatcher, $storage, $options);
  }

  public function addIdentify($identity_token, $old_identity)
  {

    if($old_identity && $old_identity->getIdentifier() == $identity_token->getIdentifier()){
        $old_identity->save(); //update the last update value
    } else {
      // validate here... the NEW identity
      $identity_token->setName(IdentityTable::getdomainfromidentify($identity_token->getIdentifier()));
      $identity_token->setStatus('access');
      $identity_token->save();
    }

  }

  public function signOut()
  {
    $this->getAttributeHolder()->clear();
    parent::signOut();
  }

}
