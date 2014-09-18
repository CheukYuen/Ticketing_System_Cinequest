
<?php
	// --------------------------------------------------------------------- //
	//  This script generates a text log file, one for each day. This 
	//  script is run once every hour to give a list of top 10 trending 
	//  events and rush showings, giving 24 such lists in one log file. 	
	// --------------------------------------------------------------------- //

	// Start connection with database
	require("connectToDB.php");

	// Query the database to get EVENTS which have atleast one upcoming 
    // SHOWING and order them by TotalSold tickets and ShowingStartDate
	$query = "SELECT * FROM trending_Event, trending_Showing 
					WHERE trending_Event.EventID = trending_Showing.EventID
					AND trending_Showing.trendingStatus = 1
					ORDER BY trending_Event.TotalSold DESC, trending_Showing.ShowingStartDate";
	$result = mysql_query($query,$con);	
	
	$phpResponseTrendingName = array();
	$phpResponseTrendingTotalSold = array();
	
	// this variable updates the latest EVENT Name
	$temp = "";
	
	// this variable keeps a count on the number of EVENTS stored in array
	// we need to limit this count to 10
	$count = 0;
	while ($count < 10 && $row = mysql_fetch_assoc($result)) {	
		
		$Name = $row['Name'];
		
		// If the EVENT is not already stored, save the required details
		if($temp != $Name) {		
			$count++;
			$temp = $Name;			 
			
			// Save required EVENT details
			$phpResponseTrendingName[] = $Name;
			$phpResponseTrendingTotalSold[] = $TotalSold = $row['TotalSold'];;
		}
	}
	
	// Query the database to get the Top 10 RushStatus SHOWINGS
	// and order them by ShowingStartDate
	$query = "SELECT * FROM trending_Event, trending_Showing
				WHERE trending_Event.EventID = trending_Showing.EventID
				AND trending_Showing.rushStatus = 1
				AND trending_Showing.trendingStatus = 1
				ORDER BY trending_Showing.ShowingStartDate
				LIMIT 10";
	$result = mysql_query($query,$con);

	$phpResponseTrending = array();
	while ($row = mysql_fetch_assoc($result)) {
		// Save required SHOWING details
		$phpResponseRushStatus[] = $row['Name'];
	}

	// --------------------------------------------------------------------- //
	//  Generate log file from PHP arrays
	// --------------------------------------------------------------------- //
	date_default_timezone_set('America/Los_Angeles');
	$dateTime = date('Y-m-d H:i:s');
	$currDateTime = dateTimeToArray($dateTime, 0);
	
	$logFile = "logFiles/logFile".$currDateTime[0].$currDateTime[1].$currDateTime[2].".txt";
	
	// open log file
	$fh = fopen($logFile, 'a') or die("can't open file");
	
	// header 1 of log file
	$stringData = "- - - - - - - - - - - - - - - - - - - - \n".
				"\nDate: ".$dateTime;
	fwrite($fh, $stringData);
	
	// Write the top 10 trending films to the log file
	$stringData = "\n\nTop 10 Trending Films \n";
	fwrite($fh, $stringData);
	
	$c = count($phpResponseTrendingName);
	for ($t = 0; $t < $c; $t++) {
		$trendingName = $phpResponseTrendingName[$t];
		$trendingTotalSold = $phpResponseTrendingTotalSold[$t];
		$stringData = ($t+1).". ".$trendingName." (".$trendingTotalSold.")\n";
		fwrite($fh, $stringData);
	}
	
	// Write the top 10 rush status screenings to the log file
	$stringData = "\n\nTop 10 Rush Screenings \n";
	fwrite($fh, $stringData);
	
	$c = count($phpResponseRushStatus);
	for ($r = 0; $r < $c; $r++) {
		$rushStatus = $phpResponseRushStatus[$r];
		$stringData = ($r+1).". ".$rushStatus."\n";
		fwrite($fh, $stringData);
	}
	
	// footer
	$stringData = "\n- - - - - - - - - - - - - - - - - - - -\n";
	fwrite($fh, $stringData);
	
	// close log file
	fclose($fh);

	// --------------------------------------------------------------------- //
	//  Function definition for separating date/time values
	// --------------------------------------------------------------------- //
	function dateTimeToArray($inputDateTime, $isEvent) {
		$dateTime = array();
		if ($isEvent == 1) {
			$dateTime = explode("T", $inputDateTime);
		} else {
			$dateTime = explode(" ", $inputDateTime);
		}
		
		$date = explode("-", $dateTime[0]);
		$time = explode(":", $dateTime[1]);
		$dateTime = array ($date[0], $date[1], $date[2], $time[0], $time[1], $time[2]);
		
		return $dateTime;
	}
?>
