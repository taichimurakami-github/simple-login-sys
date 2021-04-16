<?php
namespace App\common;

/**
 * ExceptionCode: エラーメッセージの管理を行う
 */

class ExceptionCode {
  static private $E_CODE_ARR = array(
    /**
     * 1000番台：システムエラー関係
     * 1000 ~ 1099 : 通信関係のエラー
     * 1100 ~ 1199 : データベース関係のエラー
     */
    "1000" => "POST経由での値の受け渡しに失敗しました。",
    "1001" => "SESSIONでの値の受け渡しに失敗しました。",
    "1002" => "対応するエラーコードがありません",

    /**
     * 2000番台：アプリケーションエラー関係
     * 2000 ~ 2099 : メソッド関係のエラー
     */
    "2001" => "引数の値が不正です"

  );

  /**
   * エラーコードに対応するエラーメッセージを返す
   * @param char
   * @return char
   */
  static public function getErrorMsg($err_code)
  {
    /**
     * 引数が文字型以外で渡された時の処理
     * 整数型の場合のみ型キャストを行い、それ以外はエラー
     */
    switch(gettype($err_code)){
      case "string":
        $err_code = (int) $err_code;
        break;
      case "integer":
        break;
      default:
        throw new \Exception("引数の型エラー");
    }

    /**
     * 対応するエラーメッセージが存在すれば、メッセージを返す
     * なければ例外を発生させる
     */
    if(array_key_exists($err_code, self::$E_CODE_ARR)){
      return self::$E_CODE_ARR[$err_code];
    } else {
      return self::$E_CODE_ARR["2001"];
    }

  }
}