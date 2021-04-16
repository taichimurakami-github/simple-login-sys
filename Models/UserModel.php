<?php
namespace App\model;
require("UserModelBase.php");

class UserModel extends UserModelBase {
  /**
   * パスワードの照合
   * 照合結果の成否をboolで返す
   * @param char $post_password
   * @return boolean
   */
  public function checkPassword($post_password)
  {
    return $this->_password === $post_password ? true : false;
  }

  /**
   * アカウント情報を一括でUserModelクラスのプロパティに指定
   * @param char $data
   * @return void
   */
  public function setPropertyAll($data)
  {
    $this->setUserId($data['userId'])
      ->setPassword($data['password'])
      ->setUserName($data['userName'])
      ->setEmail($data['email'])
      ->setToken($data['token'])
      ->setLoginFailureCount($data['loginFailureCount'])
      ->setLoginFailureDatetime($data['loginFailureDatetime']);
    
    return;
  }

  /**
   * ログイン失敗時に起動
   * loginFailureCountが一定数であれば、アカウントをロックする
   * そうでなければ、loginFailureCount, loginFailureDatetimeを更新・インクリメントする
   * @return void;
   */
  public function loginFailure(){

    return;
  }

  private function isAccountLock()
  {
    return false;
  }
}