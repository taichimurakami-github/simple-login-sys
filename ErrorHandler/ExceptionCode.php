<?php
namespace App\common;

/**
 * ExceptionCode: エラーメッセージの管理を行う
 */

class ExceptionCode {
  /**
   * 1000番台：SystemErrorException関係
   */
  const UNDEFINED_ERROR = '1000';
  const POST_ERROR = '1001';
  const SESSION_ERROR = '1002';
  const DB_CONNECT_GET_ERROR = '1003';
  

  /**
   * 2000番台：ApplicationErrorException関係
   */
  const NO_ERROR_CODE = '2000';

  /**
   * 3000番台：InvalidErrorException関係
   */
  const LOGIN_FAILED = '3000';
  const ACCOUNT_LOCKED = '3001';
  const EMPTY_INPUT = '3002';

  static private $E_CODE_ARR = array(
    /**
     * 1000番台：SystemErrorException関係
     */
    self::POST_ERROR => "システム内部での値の受け渡しに失敗しました。",
    self::SESSION_ERROR => "システム内部での値の受け渡しに失敗しました。",
    self::DB_CONNECT_GET_ERROR => "アカウント情報が存在しません。もしくは、データベースとの通信に失敗しました。",
    self::UNDEFINED_ERROR => "予期せぬエラーが発生しました。",

    /**
     * 2000番台：ApplicationErrorException関係
     */
    self::NO_ERROR_CODE => "引数の値が不正です。",

    /**
     * 3000番台：InvalidErrorException関係
     */
    self::LOGIN_FAILED => "アカウントへのログインに失敗しました。メールアドレスまたはパスワードを正しく入力してください。",
    self::ACCOUNT_LOCKED => "連続したログイン失敗のため、お使いのアカウントはロックされています。30分ほどおいてから再びログイン操作を行ってください。",
    self::EMPTY_INPUT => "メールアドレスまたはパスワードが入力されていません。ログインページに戻って、もう一度入力してください。"

  );

  /**
   * エラーコードに対応するエラーメッセージを返す
   * @param char
   * @return char
   */
  static public function getErrorMsg($err_code)
  {
    /**
     * 対応するエラーメッセージが存在すれば、メッセージを返す
     * なければ例外を発生させる
     */
    if(array_key_exists($err_code, self::$E_CODE_ARR)){
      return self::$E_CODE_ARR[$err_code];
    } else {
      return self::$E_CODE_ARR[self::NO_ERROR_CODE];
    }

  }
}