<?php
	// --------------------------------------------------------------------- //
	//  This script connects to the database. This file will be included in 
	//  all the files that need to access the database. 
	// --------------------------------------------------------------------- //
	
//include_once "../inc/db.php";

//	$hostname = $hostname;
//	$username = $dbname;
//	$password = $passwd;

	$hostname = "127.0.0.1";
	$username = "root";
	$password = "";

	$con = mysql_connect($hostname, $username, $password);
	if(!$con)
	{
		die("Cannot connect to Database");
	}
	
	// Select a database
	$dbname = "trending";
	$dbselect = mysql_select_db($dbname,$con);
	if(!$dbselect)
	{
		die("Cannot select Database");
	}
?>
