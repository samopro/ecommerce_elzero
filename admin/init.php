<?php

include 'connect.php';

// Routes

$tpl  = 'includes/templates/';	// Templates Directory
$func = 'includes/functions/';  // Functions Directory
$css  = 'layout/css/';   // CSS Directory
$js   = 'layout/js/';	// JS Directory
$lang = 'includes/languages/'; // Languages Directory

// Include the importants files
include $func 	. 'functions.php';
include $tpl 	. 'header.php';
include $lang 	. 'english.php';

// Include navbar on all pages except the one with $noNavbar variable
if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }
