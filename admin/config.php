<?php

/**
 * @author duchanh
 * @copyright 2012
 */ 
 
header("Content-Type: text/html; charset=UTF-8");
//if (!session_id()) session_start();

function authenticate() {
    header('WWW-Authenticate: Basic realm="Test Authentication System"');
    header('HTTP/1.0 401 Unauthorized');
    echo "You must enter a valid login ID and password to access this page\n";
    exit;
}

include('../config.php');
//include('../function.php');
$tbl_prefix = "tbl_";
global $admin_title;
$admin_title = $_SERVER['HTTP_HOST'];
?>