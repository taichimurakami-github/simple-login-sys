<?php
/**
 * config variables
 */
const VERSION = 1.00;
const MODE = "DEVELOPMENT";
const BASE_DIR = __DIR__;


/**
 * display errors setting
 */
if(MODE === "DEVELOPMENT"){
  ini_set('display_errors', true);
  error_reporting(E_ALL);
} else {
  ini_set('display_errors', false);
}