<?php
namespace App\common;
require("DbHandler.php");

class AccountHandler {

  public static function regist()
  {
    if(!filter_input_array(INPUT_POST)){
      throw new \Exception("invalid error");
    }

    $post_userName = filter_input(INPUT_POST, "userName");
    $post_email = filter_input(INPUT_POST, "email");
    $post_password = filter_input(INPUT_POST, "password");

    $connect = new DbHandler();
    $sql = "INSERT INTO user01(userName, email, password) VALUES (:userName, :email, :password)";
    $arr = array(
      ":userName" =>  $post_userName,
      ":email" => $post_email,
      ":password" => $post_password
    );
    $connect->insert($sql, $arr);

    header(sprintf("location: %s", "index.php"));
    return true;
  }

  public static function erace()
  {

  }
}