<?php 
	
	// --------------------------------------------------------------------- //
	//  This script generates an XMLFiles file of the Top 5 Trending EVENTS in
	//  decreasing order of the total number of tickets sold for all 
	//  SHOWINGS under that EVENT.
	//  
	//  It saves the following attributes:
	//      EVENT: Name, TabletLink
	//      SHOWING: ShowingStartDate, ShowingVenueName (for the upcoming SHOWING)
	// --------------------------------------------------------------------- //
	
	// Start connection with database
	require("connectToDB.php");
		
	// Query the database to get EVENTS which have atleast one upcoming 
    // SHOWING and order them by TotalSold tickets and ShowingStartDate
	$query = "SELECT * FROM trending_Event, trending_Showing 
					WHERE trending_Event.EventID = trending_Showing.EventID
					AND trending_Event.trendingStatus = 1
					AND trending_Showing.RushStatus = 0
					ORDER BY trending_Event.TotalSold DESC, trending_Showing.ShowingStartDate";
	$result = mysql_query($query,$con);	
	
	$phpResponseTrending = array();
	
	// this variable updates the latest EVENT Name
	$temp = "";
	
	// this variable keeps a count on the number of EVENTS stored in array
	// we need to limit this count to 5
	$count = 0;
	while ($count < 5 && $row = mysql_fetch_assoc($result)) {
		
		$Name = $row['Name'];
		
		// If the EVENT is not already stored, save the required details
		if($temp != $Name) {
			
			$count++;
			$temp = $Name;
			
			$TabletLink = $row['TabletLink'];
			$TotalSold = $row['TotalSold'];
			$ShowingStartDate = $row['ShowingStartDate'];
			$ShowingVenueName = $row['ShowingVenueName'];
			
			$phpResponseTrending[] = array("Name"=>$Name, 
								"TabletLink"=>$TabletLink,
								"TotalSold"=>$TotalSold,
								"StartDate"=>$ShowingStartDate, 
								"VenueName"=>$ShowingVenueName);
		}
		
	}
	
	// Print the data along with the generation of XMLFiles file, if needed
	echo "<pre>";
	print_r($phpResponseTrending);
	echo "</pre>";
	
	// --------------------------------------------------------------------- //
	//  Generating XMLFiles file from PHP array
	// --------------------------------------------------------------------- //
	
	// Create object of SimpleXMLElement which will store the entire XMLFiles document
	$phpResponseToXML = new SimpleXMLElement("<?xml version=\"1.0\"?><ArrayOfShows></ArrayOfShows>");

	// Function call to convert PHP array to XMLFiles
	array_to_xml($phpResponseTrending,$phpResponseToXML);
	
	// Print generated XMLFiles file, if required
	// print_r($phpResponseToXML);
	
	// Save the generated XMLFiles file
	$phpResponseToXML->asXML('XMLFiles/Trending_Top5Events.xml');
	
	// Function definition for converting PHP array to XMLFiles
	function array_to_xml($phpResponseTrending, &$phpResponseToXML) {
		foreach ($phpResponseTrending as $key => $value) {
			if (is_array($value)) {	
				if (!is_numeric($key)) {
					// For non-numeric keys, give name same as key to the node
					$subnode = $phpResponseToXML->addChild("$key");
					
					// Recursive call to the function since the value was an array
					array_to_xml($value, $subnode);
				} else {
					// For numeric keys, give a name to the node 
					$subnode = $phpResponseToXML->addChild("Show");
					//Recursive call to the function since the value was an array
					array_to_xml($value, $subnode);
				}
			}
			else {
				// Save the node and its value in XMLFiles format
				//$phpResponseToXML->addChild("$key","$value");
				$phpResponseToXML->$key = $value;
			}	
		}
	}

?>