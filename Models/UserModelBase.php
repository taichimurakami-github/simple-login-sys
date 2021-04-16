<?php
namespace App\model;

class UserModelBase {
  protected $_userId = '';
  protected $_password = '';
  protected $_userName = '';
  protected $_email = '';
  protected $_token = '';
  protected $_loginFailureCount = '';
  protected $_loginFailureDatetime = '';

  /**
   * property setter
   */
  public function setUserId($userId)
  {
    return $this->_userId = $userId;
  }
  public function setPassword($password)
  {
    return $this->_password = $password;
  }
  public function setUserName($userName)
  {
    return $this->_userName = $userName;
  }
  public function setEmail($email)
  {
    return $this->_email = $email;
  }
  public function setToken($token)
  {
    return $this->_token = $token;
  }
  public function setLoginFailureCount($loginFailureCount)
  {
    return $this->_loginFailureCount = $loginFailureCount;
  }
  public function setLoginFailureDatetime($loginFailureDatetime)
  {
    return $this->_loginFailureDatetime = $loginFailureDatetime;
  }


  /**
   * property getter
   */
  public function getUserId()
  {
    return $this->_userId;
  }
  public function getPassword()
  {
    return $this->_password;
  }
  public function getUserName()
  {
    return $this->_userName;
  }
  public function getEmail()
  {
    return $this->_email;
  }
  public function getToken()
  {
    return $this->_token;
  }
  public function getLoginFailureCount()
  {
    return $this->_loginFailureCount;
  }
  public function getLoginFailureDatetime()
  {
    return $this->_loginFailureDatetime;
  }
}