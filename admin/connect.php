<?php
  
  $dsn 	= 'mysql:host=localhost;dbname=shop';
  $user = 'root';
  $pass = 'myadminpassword321@#';
  $option = array(
  		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
  );


  try {
  	$db = new PDO($dsn, $user, $pass, $option);
  	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
  	// echo "You are Connected!";
  } catch(PDOException $e) {
  	echo "Failed to connect" . $e->getMessage();
  }
