<?php 
	
	// --------------------------------------------------------------------- //
	//  This script generates an XMLFiles file of EVENTS that have at least one
	//  SHOWING. It saves the following attributes:
	//      EVENT: EventID, Name, Duration, ThumbImage, EventImage, InfoLink
	//      SHOWING: ShowingID, StartDate, EndDate, Duration, SalesMessage, 
	//              LegacyPurchaseLink, VenueName
	// --------------------------------------------------------------------- //
	
	// Start connection with database
	require("connectToDB.php");

	// Query the database to get all the EVENTS
	$query = "SELECT * FROM trending_Event";
	$result = mysql_query($query,$con);	
	
	$phpResponse = array();
	while ($row = mysql_fetch_assoc($result)) {
		
		// Save EVENT details
		$EventID = $row['EventID'];
		$Name = $row['Name'];
		$Duration = $row['Duration'];
		$ThumbImage = $row['ThumbImage'];
		$EventImage = $row['EventImage'];
		$InfoLink = $row['InfoLink'];
	
		// Query the database to get the SHOWINGS of the current EVENT
		$Showing = array();
		$queryShowing = "SELECT * FROM trending_Showing WHERE EventID = ".$row['EventID'];
		$resultShowing = mysql_query($queryShowing,$con);
		
		while ($rowShowing = mysql_fetch_assoc($resultShowing)) {
			
			// Save the SHOWING details in Showing array
			$ShowingID = $rowShowing['ShowingID'];
			$ShowingStartDate = $rowShowing['ShowingStartDate'];
			$ShowingEndDate = $rowShowing['ShowingEndDate'];
			$ShowingDuration = $rowShowing['ShowingDuration'];
			$ShowingSalesMessage = $rowShowing['ShowingSalesMessage'];
			$ShowingLegacyPurchaseLink = $rowShowing['ShowingLegacyPurchaseLink'];
			$ShowingVenueName = $rowShowing['ShowingVenueName'];
			
			$Showing[] = array("ID"=>$ShowingID, 
								"StartDate"=>$ShowingStartDate, 
								"EndDate"=>$ShowingEndDate, 
								"Duration"=>$ShowingDuration, 
								"SalesMessage"=>$ShowingSalesMessage, 
								"LegacyPurchaseLink"=>$ShowingLegacyPurchaseLink, 
								"VenueName"=>$ShowingVenueName);
		}
		
		// Save the EVENT details in phpResponse array
		$phpResponse[] = array("ID" => $EventID, 
								"Name" => $Name, 
								"Duration" => $Duration, 
								"ThumbImage" => $ThumbImage, 
								"EventImage" => $EventImage, 
								"InfoLink" => $InfoLink, 
								"CurrentShowings" => $Showing);
	
	}
	
	// Print the data along with the generation of XMLFiles file, if needed
	echo "<pre>";
	print_r($phpResponse);
	echo "</pre>";
	
	// --------------------------------------------------------------------- //
	//  Generating XMLFiles file from PHP array
	// --------------------------------------------------------------------- //
	 
	// Create object of SimpleXMLElement which will store the entire XMLFiles document
	$phpResponseToXML = new SimpleXMLElement("<?xml version=\"1.0\"?><ArrayOfShows></ArrayOfShows>");

	// Function call to convert PHP array to XMLFiles
	array_to_xml($phpResponse,$phpResponseToXML);
	
	// Print generated XMLFiles file, if needed
	// print_r($phpResponseToXML);
	
	// Save the generated XMLFiles file
	$phpResponseToXML->asXML('XMLFiles/EventsWithShowings.xml');
	
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
					//$subnode = $phpResponseToXML->addChild("item$key");
					if (current($phpResponseToXML->xpath('parent::*'))) {
						$subnode = $phpResponseToXML->addChild("Showing");
					}
					else {
						$subnode = $phpResponseToXML->addChild("Show");
					}
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