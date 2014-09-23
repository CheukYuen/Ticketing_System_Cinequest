<?php
/**
 * Created by PhpStorm.
 * User: zlin
 * Date: 9/20/14
 * Time: 3:29 PM
 */


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
$result = mysql_query($query, $con);


//echo "<pre>hello";
//$count_t = 0;
//
//while ($count_t < 1) {
//    print_r(mysql_fetch_assoc($result));
//    $count_t++;
//}
//echo "</pre>";

$phpResponseTrending = array();

// this variable updates the latest EVENT Name
$temp = "";

// this variable keeps a count on the number of EVENTS stored in array
// we need to limit this count to 5
$count = 0;

$currDateTime = dateTimeToArray('2014-03-15 12:53:00', 0);
while ($count < 7 && $row = mysql_fetch_assoc($result)) {

    $Name = $row['Name'];


    $ShowingStartDate = $row['ShowingStartDate'];

    $showingDateTime = dateTimeToArray($ShowingStartDate, 1);


    echo "</pre>";
    // If the EVENT is not already stored, save the required details
    if (isLess($currDateTime, $showingDateTime) == -1) {
//        if ($temp != $Name) {
        if ($temp == $temp) {


            echo "<pre>";


            print_r($showingDateTime);
            print_r($ShowingStartDate);
//                print_r($currDateTime);
            print_r($Name);
            echo "hello";

            $count++;
            $temp = $Name;

            $TabletLink = $row['TabletLink'];
            $TotalSold = $row['TotalSold'];

            $ShowingVenueName = $row['ShowingVenueName'];

            $phpResponseTrending[] = array("Name" => $Name,
                "TabletLink" => $TabletLink,
                "TotalSold" => $TotalSold,
                "StartDate" => $ShowingStartDate,
                "VenueName" => $ShowingVenueName);


        }


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
array_to_xml($phpResponseTrending, $phpResponseToXML);

// Print generated XMLFiles file, if required
// print_r($phpResponseToXML);

// Save the generated XMLFiles file
$phpResponseToXML->asXML('XMLFiles/Trending_Top5Events.xml');

// Function definition for converting PHP array to XMLFiles
function array_to_xml($phpResponseTrending, &$phpResponseToXML)
{
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
        } else {
            // Save the node and its value in XMLFiles format
            //$phpResponseToXML->addChild("$key","$value");
            $phpResponseToXML->$key = $value;
        }
    }
}


function dateTimeToArray($inputDateTime, $isEvent)
{
    $dateTime = array();
    if ($isEvent == 1) {
        $dateTime = explode("T", $inputDateTime);
    } else {
        $dateTime = explode(" ", $inputDateTime);
    }

    $date = explode("-", $dateTime[0]);
    $time = explode(":", $dateTime[1]);
    $dateTime = array($date[0], $date[1], $date[2], $time[0], $time[1], $time[2]);

    return $dateTime;
}

function isLess($currDateTime, $showingDateTime)
{
    // compare year
    if ($currDateTime[0] < $showingDateTime[0]) {
        return -1;
    }
    if ($currDateTime[0] > $showingDateTime[0]) {
        return 1;
    }

    // compare month
    if ($currDateTime[1] < $showingDateTime[1]) {
        return -1;
    }
    if ($currDateTime[1] > $showingDateTime[1]) {
        return 1;
    }

    // compare day
    if ($currDateTime[2] < $showingDateTime[2]) {
        return -1;
    }
    if ($currDateTime[2] > $showingDateTime[2]) {
        return 1;
    }

    // compare hour
    if ($currDateTime[3] < $showingDateTime[3]) {
        return -1;
    }
    if ($currDateTime[3] > $showingDateTime[3]) {
        return 1;
    }

    // compare minutes
    if ($currDateTime[4] < $showingDateTime[4]) {
        return -1;
    }
    if ($currDateTime[4] > $showingDateTime[4]) {
        return 1;
    }

    // compare seconds
    if ($currDateTime[5] < $showingDateTime[5]) {
        return -1;
    }
    if ($currDateTime[5] > $showingDateTime[5]) {
        return 1;
    }
    return 0;
}


?>