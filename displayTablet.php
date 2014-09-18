<!DOCTYPE html>
<!--// --------------------------------------------------------------------- //
	//  This script takes in the Trending_Top10Events.xml and 
	//  RushStatus_Top10Showings.xml and prints the 
	//  following data:
	//      
	//      TRENDING EVENTS:
	//      EVENT Name, with a hyperlink to its TabletLink
	//      ShowingStartDate (of the upcoming SHOWING) in format: MM/DD HH:MM (12-hour)
	//      
	//      RUSH SHOWINGS:
    //      EVENT Name under which the SHOWING falls, with a hyperlink to its TabletLink
	//      ShowingStartDate in format: MM/DD HH:MM (12-hour)
	// --------------------------------------------------------------------- // -->

<html>
<head>
    <title>
        .: Top TRENDING Events & RUSH Showings :.
    </title>

    <link rel="stylesheet" type="text/css" href="css/displayTabletStyle.css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
</head>

<body>

<div id="main">

    <!----------------------------------------------------------------------- //
    //                         TRENDING EVENTS
    // ----------------------------------------------------------------------->
    <div class="headingWrapper">
        <div class="headingFiller1">&nbsp;</div>
        <div class="heading">Trending Films</div>
        <div class="headingFiller2">&nbsp;</div>
    </div>

    <?php
    $nameLength = 12;

    // Load XMLFiles in PHP variables
    $xml_trending = simplexml_load_file("XMLFiles/Trending_Top5Events.xml");

    // Start a new list to print the TRENDING EVENTS

    foreach ($xml_trending->Show as $show):

        // Save the SELECTED attributes for each EVENT, in PHP variables
        $originalName = $show->Name;
        if (strlen($originalName) > $nameLength) {
            $Name = substr($originalName, 0, $nameLength) . "...";
        } else {
            $Name = $originalName;
        }

        $TabletLink = $show->TabletLink;
        $StartDate = $show->StartDate;
        $VenueName = $show->VenueName;

        // Separate date and time
        $dateTime = dateTimeToArray($StartDate);

        // Convert the date and time in MM/DD HH:MM (12-hour) format
        $month = monthName($dateTime[1]);
        $day = $dateTime[2];
        $day = $dateTime[2];

        $hour = $dateTime[3];
        if ($hour < 12) {
            $ampm = "AM";
        } else if ($hour > 12) {
            $ampm = "PM";
            $hour = $hour - 12;
        } else if ($hour == 12) {
            $ampm = "PM";
        }
        $min = $dateTime[4];

        // Print the saved values
        ?>

        <div class="contentWrapper">
            <div class="contentFiller1">&nbsp;</div>
            <div class="content">
                <div class="leftColumn"><a href="<?php echo $TabletLink; ?>"><?php echo $Name; ?></a></div>
                <div class="rightColumn">
                    <div class="venue"><?php echo $VenueName; ?></div>
                    <div class="dateTime">
                        <?php echo $month; ?> <?php echo $day; ?> @ <?php echo $hour; ?>
                        :<?php echo $min; ?> <?php echo $ampm; ?>
                    </div>
                </div>
            </div>
            <div class="contentFiller2">&nbsp;</div>
        </div>

    <?php
    endforeach;
    ?>

    <!----------------------------------------------------------------------- //
    //                         RUSH SHOWINGS
    // ----------------------------------------------------------------------->
    <div class="headingWrapper">
        <div class="headingFiller1">&nbsp;</div>
        <div class="heading">Rush Films</div>
        <div class="headingFiller2">&nbsp;</div>
    </div>

    <?php

    // Load XMLFiles in PHP variables
    $xml_rush = simplexml_load_file("XMLFiles/RushStatus_Top5Showings.xml");

    // Start a new list to print the TRENDING EVENTS

    foreach ($xml_rush->Showing as $showing):

        // Save the SELECTED attributes for each EVENT, in PHP variables
        $originalName = $showing->Name;
        if (strlen($originalName) > $nameLength) {
            $Name = substr($originalName, 0, $nameLength) . "...";
        } else {
            $Name = $originalName;
        }

        $TabletLink = $showing->TabletLink;
        $StartDate = $showing->StartDate;
        $VenueName = $showing->VenueName;

        // Separate date and time
        $dateTime = dateTimeToArray($StartDate);

        // Convert the date and time in MM/DD HH:MM (12-hour) format
        $month = monthName($dateTime[1]);
        $day = $dateTime[2];


        $hour = $dateTime[3];
        if ($hour < 12) {
            $ampm = "AM";
        } else if ($hour > 12) {
            $ampm = "PM";
            $hour = $hour - 12;
        } else if ($hour == 12) {
            $ampm = "PM";
        }
        $min = $dateTime[4];

        // Print the saved values
        ?>


        <div class="contentWrapper">
            <div class="contentFiller1">&nbsp;</div>
            <div class="content">
                <div class="leftColumn"><a href="<?php echo $TabletLink; ?>"><?php echo $Name; ?></a></div>
                <div class="rightColumn">
                    <div class="venue"><?php echo $VenueName; ?></div>
                    <div class="dateTime">
                        <?php echo $month; ?> <?php echo $day; ?> @ <?php echo $hour; ?>
                        :<?php echo $min; ?> <?php echo $ampm; ?>
                    </div>
                </div>
            </div>
            <div class="contentFiller2">&nbsp;</div>
        </div>

    <?php
    endforeach;
    ?>

    <div id="lastRowWrapper">
        <div class="lastRowFiller1">&nbsp;</div>
        <div id="lastRow"></div>
        <div class="lastRowFiller2">&nbsp;</div>
    </div>


</div>
<?php
// --------------------------------------------------------------------- //
//  Function definition for separating date/time values
// --------------------------------------------------------------------- //
function dateTimeToArray($inputDateTime)
{
    $dateTime = explode("T", $inputDateTime);

    $date = explode("-", $dateTime[0]);
    $time = explode(":", $dateTime[1]);
    $dateTime = array($date[0], $date[1], $date[2], $time[0], $time[1], $time[2]);

    return $dateTime;
}

// --------------------------------------------------------------------- //
//  Function definition for changing month number to month name
// --------------------------------------------------------------------- //
function monthName($monthNumber)
{
    switch ($monthNumber) {
        case 1:
            return "Jan";
            break;
        case 2:
            return "Feb";
            break;
        case 3:
            return "Mar";
            break;
        case 4:
            return "Apr";
            break;
        case 5:
            return "May";
            break;
        case 6:
            return "Jun";
            break;
        case 7:
            return "Jul";
            break;
        case 8:
            return "Aug";
            break;
        case 9:
            return "Sep";
            break;
        case 10:
            return "Oct";
            break;
        case 11:
            return "Nov";
            break;
        case 12:
            return "Dec";
            break;
    }
}

?>

</body>
</html>