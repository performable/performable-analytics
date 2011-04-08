<?php
  /**
   *  Usage
 
      $p = new Performable('XXXXXX'); // your account number
      $p->setId('123456');            // internal application id (optional)
      $p->setEmail('jane@doe.com');   // visitor's email address (optional)
      $p->setValue(124);              // purchase amount from shopping cart (optional)

      // additional properties you would like associated with the visitor
      $p->setCustomProperties(array('plan' => 'enterprise'));
      echo $p;

      // NOTE: requires json_encode function/library

   **/

  class Performable
  {

    var $accountId = "";
    var $identity = array();
    
    public function __construct($accountId)
    {
      $this->accountId = $accountId;
    }

    public function setEmail($email)
    {
      if(preg_match('|^\S+@\S+\.\S+$|i', $email)) {
        $this->identity['email'] = $email;
      }
    }

    public function setLastName($last_name)
    {
      if(!empty($last_name)) {
        $this->identity['last_name'] = $last_name;
      }
    }

    public function setFirstName($first_name)
    {
      if(!empty($first_name)) {
        $this->identity['first_name'] = $first_name;
      }
    }

    public function setFacebookId($facebookId)
    {
      if(!empty($facebookId)) {
        $this->identity['facebook_id'] = $facebookId;
      }
    }

    public function setFacebookUsername($facebook_username)
    {
      if(!empty($facebook_username)) {
        $this->identity['facebook'] = $facebook_username;
      }
    }

    public function setTwitterId($twitterId)
    {
      if(!empty($twitterId)) {
        $this->identity['twitter_id'] = $twitterId;
      }
    }

    public function setTwitterUsername($twitter_username)
    {
      if(!empty($twitter_username)) {
        $this->identity['twitter'] = $twitter_username;
      }
    }

    public function setId($id)
    {
      if(!empty($id)) {
        $this->identity['id'] = $id;
      }
    }

    public function setValue($value)
    {
      if(is_numeric($value)) {
        $this->identity['value'] = $value;
      }
    }

    public function setCustomProperties($arr) {
      if(!empty($arr)) {
        $this->identity = array_merge($this->identity, (array) $arr);
      }
    }

    public function __toString()
    {
      $lines = array();
      if(!empty($this->identity)) {
        $lines[] = '<script type="text/javascript">';
        $lines[] = 'var _paq = _paq || [];';
        $lines[] = sprintf('_paq.push(["identify", %s]);', json_encode($this->identity));
        $lines[] = '</script>';
      }
      $lines[] = sprintf('<script src="//d1nu2rn22elx8m.cloudfront.net/performable/pax/%s.js"></script>', $this->accountId);
      return join("\n", $lines);
    }
  }
?>
