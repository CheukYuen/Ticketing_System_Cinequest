<?php

	// --------------------------------------------------------------------- //
	//  This script builds up the database and needs to be run once to 
	//  create the tables of database.
	// --------------------------------------------------------------------- //
	
	// Start connection
	require("connectToDB.php");
	
	// Create Event table
	$query = "create table if not exists trending_Event (EventID int, 
												Name varchar(128),
												Duration int,
												ThumbImage varchar(128),
												EventImage varchar(128), 
												InfoLink varchar(128),
												TabletLink varchar(128),
												BitlyLink varchar(128),
												TotalSold int,
												TrendingStatus bool,
												PRIMARY KEY (EventID))";

	$result = mysql_query($query,$con);	
	if(!$result)
	{
		die("Invalid query! <br> The query is: " . $query);
	}
	
	// Create Showing table
	$query = "create table if not exists trending_Showing (ShowingID int, 
													EventID int, 
													ShowingStartDate varchar(32), 
													ShowingEndDate varchar(32),
													ShowingDuration int, 
													ShowingSalesMessage varchar(32),
													ShowingLegacyPurchaseLink varchar(128), 
													ShowingVenueID int, 
													ShowingVenueName varchar(32), 
													Available int,
													Disabled int,
													Sold int,
													InProcess int,
													RushStatus bool,
													PRIMARY KEY (ShowingID))";
	
	$result = mysql_query($query,$con);	
	if(!$result)
	{
		die("Invalid query! <br> The query is: " . $query);
	}

	// Close connection to database
	mysql_close($con);

	// Message pops up if the database is created successfully
	echo "Database created successfully!";	
?>