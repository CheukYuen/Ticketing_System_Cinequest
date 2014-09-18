<?php
	// --------------------------------------------------------------------- //
	//  This script will send e-mail to required people with log file 
	//  as attachment, once everyday. 
	// --------------------------------------------------------------------- //
	
	// Set the time-zone so the system takes in the correct current date and time
	date_default_timezone_set('America/Los_Angeles');
	$dateTime = date('Y-m-d H:i:s');
	$currDateTime = dateTimeToArray($dateTime, 0);
	
	// Set various email fields: to, from, subject, and so on
	$filename = "logFiles/logFile".$currDateTime[0].$currDateTime[1].$currDateTime[2].".txt";
	$to  = "sharvari.kapadia@gmail.com";
	$from = "skapadia@cinequest.org";
	$from_name = "Sharvari Kapadia";
 	$replyto = "kapadia.sharvari@gmail.com";
	$subject = "Trending Films Log File for ".$currDateTime[1]."/".$currDateTime[2]; 
	$message = "Please find the Trending films Log File for ".
				$currDateTime[1]."/".$currDateTime[2].".".
				"If you have any questions, please speak with Matt or Lou.";

	// Updated contacts list
	$to = "mopsal@cinequest.org";
	$from = "cquest@bravo.he.net"; 
	$from_name = "CQuest at Bravo";
	$replyto = "cquest@cinequest.org";

	mail_attachment($filename, $to, $from, $from_name, $replyto, $subject, $message);
	
	// --------------------------------------------------------------------- //
	//  Function definition for mail_attachment()
	// --------------------------------------------------------------------- //
	function mail_attachment($filename, $to, $from, $from_name, $replyto, $subject, $message) {
		$file = $filename;
		$file_size = filesize($file);
		$handle = fopen($file, "r");
		$content = fread($handle, $file_size);
		fclose($handle);
		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		$name = basename($file);
		$header = "From: ".$from_name." <".$from.">\r\n";
		$header .= "Reply-To: ".$replyto."\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		$header .= "This is a multi-part message in MIME format.\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		$header .= $message."\r\n\r\n";
		$header .= "--".$uid."\r\n";
		$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
		$header .= "Content-Transfer-Encoding: base64\r\n";
		$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
		$header .= $content."\r\n\r\n";
		$header .= "--".$uid."--";
		if (mail($to, $subject, "", $header)) {
			echo "mail sent ... OK";
		} else {
			echo "mail not sent ... ERROR!";
		}
	}
	
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
