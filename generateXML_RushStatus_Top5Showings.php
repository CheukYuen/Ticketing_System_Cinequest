<?php
	// --------------------------------------------------------------------- //
	//  DUE TO LACK OF NEW DATA, THIS SCRIPT WOULD GENERATE AN EMPTY XMLFiles
	//  FILE RIGHT NOW.
	// --------------------------------------------------------------------- //

	// --------------------------------------------------------------------- //
	//  This script generates an XMLFiles file of the Top 5 RushStatus SHOWINGS
	//  in order of ShowingStartDate, starting with the nearest upcoming SHOWING.
	//
	//  It saves the following attributes:
	//      EVENT: Name, TabletLink
	//      SHOWING: ShowingStartDate, ShowingVenueName
	// --------------------------------------------------------------------- //

	// Start connection with database
	require("connectToDB.php");

	// Query the database to get the Top 5 RushStatus SHOWINGS
	// and order them by ShowingStartDate
    // remove AND trending_Event.trendingStatus = 1 By Leon
	$query = "SELECT * FROM trending_Event, trending_Showing
				WHERE trending_Event.EventID = trending_Showing.EventID
				AND trending_Showing.rushStatus = 1
				ORDER BY trending_Showing.ShowingStartDate DESC
				LIMIT 5";
    $result = mysql_query($query,$con);

	$phpResponseRushStatus = array();
	while ($row = mysql_fetch_assoc($result)) {

		// Save required EVENT/SHOWING details
		$Name = $row['Name'];
		$TabletLink = $row['TabletLink'];
		$ShowingStartDate = $row['ShowingStartDate'];
		$ShowingVenueName = $row['ShowingVenueName'];

		$phpResponseRushStatus[] = array("Name"=>$Name,
							"TabletLink"=>$TabletLink,
							"StartDate"=>$ShowingStartDate,
							"VenueName"=>$ShowingVenueName);
	}

    $phpResponseRushStatus  = array_reverse($phpResponseRushStatus);

	// Print the data along with the generation of XMLFiles file, if needed
	echo "<pre>";
	print_r($phpResponseRushStatus);
	echo "</pre>";

	// --------------------------------------------------------------------- //
	//  Generating XMLFiles file from PHP array
	// --------------------------------------------------------------------- //

	// Create object of SimpleXMLElement which will store the entire XMLFiles document
	$phpResponseToXML = new SimpleXMLElement("<?xml version=\"1.0\"?><ArrayOfShows></ArrayOfShows>");

	// Function call to convert PHP array to XMLFiles
	array_to_xml($phpResponseRushStatus,$phpResponseToXML);

	// Print generated XMLFiles file, if required
	// print_r($phpResponseToXML);

	// Save the generated XMLFiles file
	$phpResponseToXML->asXML('XMLFiles/RushStatus_Top5Showings.xml');

	// Function definition for converting PHP array to XMLFiles
	function array_to_xml($phpResponse, &$phpResponseToXML) {
		foreach ($phpResponse as $key => $value) {
			if (is_array($value)) {
				if (!is_numeric($key)) {
					// For non-numeric keys, give name same as key to the node
					$subnode = $phpResponseToXML->addChild("$key");

					// Recursive call to the function since the value was an array
					array_to_xml($value, $subnode);
				} else {
					// For numeric keys, give a name to the node
					$subnode = $phpResponseToXML->addChild("Showing");
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