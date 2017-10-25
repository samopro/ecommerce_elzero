<?php

// Error Reporting
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionUser = '';

if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
}

// Routes

$tpl  = 'includes/templates/';	// Templates Directory
$func = 'includes/functions/';  // Functions Directory
$css  = 'layout/css/';   // CSS Directory
$js   = 'layout/js/';	// JS Directory
$lang = 'includes/languages/'; // Languages Directory

// Include the importants files
include $func 	. 'functions.php';
include $lang 	. 'english.php';
include $tpl 	. 'header.php';

 