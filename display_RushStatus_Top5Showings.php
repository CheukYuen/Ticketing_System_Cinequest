
<!--// --------------------------------------------------------------------- //
	//  This script takes in the RushStatus_Top5Showings.xml and prints the 
	//  following data:
	//      EVENT Name under which the SHOWING falls, with a hyperlink to its TabletLink
	//      ShowingStartDate in format: MM/DD HH:MM (12-hour)
	// --------------------------------------------------------------------- // -->

<html>

<head>
	<title>
		.: Top 5 Rush Status Showings :.
	</title>
</head>

<body>
	
		<!-- header Start -->
		<div id="header"> 
			<h3>Top 5 Rush Status Showings</h3>
		</div> 
		<!-- header End -->
		
		<?php
			
			// Load XMLFiles in PHP variables
			$xml=simplexml_load_file("XMLFiles/RushStatus_Top5Showings.xml");
			
			// Start a new list to print the SHOWINGS
			echo "<ul>";
			
			foreach ($xml->Showing as $showing):
			
				// Save the SELECTED attributes for each SHOWING, in PHP variables
				$Name = $showing->Name;
				$TabletLink = $showing->TabletLink;
				$StartDate = $showing->StartDate;
				$VenueName = $showing->VenueName;
				
				// Separate date and time
				$dateTime = dateTimeToArray($StartDate, 1);
				
				// Convert the date and time in MM/DD HH:MM (12-hour) format
				$month = $dateTime[1];
				$day = $dateTime[2];
				
				$hour = $dateTime[3];
				if ($hour < 12) {
					$ampm = "AM";
				} else if($hour > 12){
					$ampm = "PM";
					$hour = $hour - 12;
				} else if($hour == 12) {
					$ampm = "PM";
				}
				$min = $dateTime[4];
				
				// Print the saved values
				echo "<li>",
					"<b><a href = '",$TabletLink,"'>",$Name,"</a></b><br>",
					$month,"/",$day," ",$hour,":",$min," ",$ampm,"<br>",
					$VenueName,"<br>",
					"</li><br>";
			
			endforeach;
		
			echo "</ul>";
			
			// --------------------------------------------------------------------- //
			//  Function definition for separating date/time values
			// --------------------------------------------------------------------- //
			function dateTimeToArray($inputDateTime, $isEvent) {
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
</body>

</html>

