<?php

/*
	Categories => [ Manage | Edit | Update | Add | Insert | Delete | Stats ]
*/


$do = isset($_GET['do']) ? $_GET['do'] : $do = 'Manage';

 // If the is main page
if ($do == 'Manage') {
	echo 'Welcome to Manage Page';
} elseif ($do == 'Add') {
	echo 'Welcome to Add Page';
} elseif ($do == 'Edit') {
	echo 'Welcome to Edit Page';
} else {
	echo 'Error';
}