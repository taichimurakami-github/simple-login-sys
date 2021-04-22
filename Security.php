<?php
namespace App\common;

class Csrf 
{
  private static $token = null;

  private static function init()
  {
    self::$token = sha1(uniqid());
  }

  public static function get()
  {
    if(is_null(self::$token))
    {
      self::init();
    }    
    $_SESSION['csrf_token'] = self::$token;
    return self::$token;
  }

  public static function verify()
  {
    if(isset($_SESSION['csrf_token']) && filter_input(INPUT_POST, 'csrf_token') !== $_SESSION['csrf_token'])
    {
      echo self::$token." , ".$_SESSION['csrf_token'];
      throw new InvalidErrorException(ExceptionCode::INVALID_CSRF_ERROR);
    }
    
    return true;
  }
}