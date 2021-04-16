<?php
namespace App\common;
use App\common\ExceptionCode;

/**
* Exception 仕様
* + エラークラス一覧
* 
* クラス名                      重要性        ログ書き出し    画面表示の文章                        管理者への通知
* -----------------------------------------------------------------------------------------------------------
* SystemErrorException         重大        TRUE          システムエラーが発生しました            TRUE(メール送信)
* ApplicationErrorException    中程度      TRUE          アプリケーションエラーが発生しました     FALSE
* InvalidErrorException        軽微        FALSE         (エラーメッセージをそのまま表示)        FALSE
* 
*/

class InvalidErrorException extends \Exception
{
  /**
   *  + エラーコードを受けたら、それに該当するエラーメッセージを吐く
   */

   /**
    * コンストラクタ
    * @param type $err_code
    * @param \Exception $previous
    */
  public function __construct($err_code, \Exception $previous = null)
  {
    $msg = ExceptionCode::getErrorMsg($err_code);
    parent::__construct($msg, $err_code, $previous);
  }
}

class ApplicationErrorException extends \Exception
{
  /**
   *  + エラーコードを受けたら、それに該当するエラーメッセージを吐く
   *  + ログを書き出す
   */

   /**
    * コンストラクタ
    * @param type $err_code
    * @param \Exception $previous
    */
  public function __construct($err_code, \Exception $previous = null)
  {
    $msg = ExceptionCode::getErrorMsg($err_code);
    self::writeLog($msg);
    parent::__construct($msg, $err_code, $previous);
  }

  /**
   * ログの書き出しを行う関数
   */
  static private function writeLog()
  {

  }
}

class SystemErrorException extends \Exception {
  /**
   *  + エラーコードを受けたら、それに該当するエラーメッセージを吐く
   *  + ログを書き出す
   *  + 管理者に連絡する
   */

   /**
    * コンストラクタ
    * @param type $err_code
    * @param \Exception $previous
    */
  public function __construct($err_code, \Exception $previous = null)
  {
    $msg = ExceptionCode::getErrorMsg($err_code);
    self::writeLog($msg);
    self::contactToAdmin($msg);
    parent::__construct($msg, $err_code, $previous);
  }

  /**
   * ログの書き出しを行う関数
   */
  static private function writeLog()
  {

  }

  /**
   * ログの書き出しを行う関数
   */
  static private function contactToAdmin()
  {

  }
}

