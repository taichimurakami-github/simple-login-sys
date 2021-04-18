<?php
require_once("../Handler/AccountHandler.php");
session_start();
App\common\AccountHandler::erace($_SESSION['UserModel']);