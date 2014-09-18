
<!--// --------------------------------------------------------------------- //
	//  This script takes in the Trending_Top5Events.xml and prints the 
	//  following data:
	//      EVENT Name, with a hyperlink to its TabletLink
	//      ShowingStartDate (of the upcoming SHOWING) in format: MM/DD HH:MM (12-hour)
	// --------------------------------------------------------------------- // -->

<html>

<head>
	<title>
		.: Top 5 Trending Events :.
	</title>
</head>

<body>
	
		<!-- header Start -->
		<div id="header"> 
			<h3>Top 5 Trending Events</h3>
		</div> 
		<!-- header End -->
		
		<?php
			
			// Load XMLFiles in PHP variables
			$xml=simplexml_load_file("XMLFiles/Trending_Top5Events.xml");
			
			// Start a new list to print the EVENTS
			echo "<ul>";
			
			foreach ($xml->Show as $show):
			
				// Save the SELECTED attributes for each EVENT, in PHP variables
				$Name = $show->Name;
				$TabletLink = $show->TabletLink;
				$StartDate = $show->StartDate;
				$VenueName = $show->VenueName;
				
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

