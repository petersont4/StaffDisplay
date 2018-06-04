<?php

include 'variables.php';

/*////////////////////////////////////////////////////
//																									//
//   Creation of XML link from evanced for spaces 	//
//																									//
////////////////////////////////////////////////////*/
$spacesXMLFile = "https://kentonlibrary.evanced.info/spaces/patron/spacesxml?dm=xml";

//Date Offset
//do=
//Accepts any positive or negative integer
$spacesXMLFile .= "&do=0";

//Featured Events
//fe=
//Set value to 1 to display featured events only.
//$spacesXMLFile .= "&fe=1";

//Ongoing events
//ongoing=
//set value to 1 to display ongoing events.
//$spacesXMLFile .= "&ongoing=1";

//Specify Branch
//lib=
//1 for single, where 1 is the library ID.
//0,999,1003,1009,1016 for multiple, where these numbers are the library IDs. No spaces.
//all indicates "all branches" (i.e. system-wide would be lib=all)
//Branch IDs start in the 1000s as show above. Your branch IDs may vary
//
//Branch List:
//999-All Locations
//1005-FORGE at the Hellmann Creative Center
//1000-Covington
//0-William E. Durr
//1001-Erlanger
//1004-Online
//1003-Off Site
//1002-Administration
//1006-Makerspace
$spacesXMLFile .= "&lib=" . $lib;

//Specific Spaces
//loc=
//7 - BB&T Meeting Room 2/3
//10- Conference Room 2
//11- Conference Room 1
//51- BB&T Meeting Room
//23- Computer Learning Center
//$spacesXMLFile .= "&loc=7,10,11,51,23";

//Reservation Status
// 0 = Pending
// 1 = Approved [Default]
$spacesXMLFile .= "&status=1";



//To see complete list of variables to add, visit
//http://kb.demcosoftware.com/article.php?id=720

$spacesData = simplexml_load_string(preg_replace('/^(<\?[xX][mM][lL]\s+[^\?\>]+encoding\s*=\s*([\'"]))utf-16\2/u','\1utf-8\2', file_get_contents($spacesXMLFile)));



/*////////////////////////////////////////////////////
//																									//
//   Creation of XML link from evanced for spaces		//
//	 pending reservations														//
//																									//
////////////////////////////////////////////////////*/
$spacesXMLFilePending = "https://kentonlibrary.evanced.info/spaces/patron/spacesxml?dm=xml";

//Date Offset
//do=
//Accepts any positive or negative integer
//$spacesXMLFilePending .= "&do=0";

//Featured Events
//fe=
//Set value to 1 to display featured events only.
//$spacesXMLFile .= "&fe=1";

//Ongoing events
//ongoing=
//set value to 1 to display ongoing events.
//$spacesXMLFile .= "&ongoing=1";

//Specify Branch
//lib=
//1 for single, where 1 is the library ID.
//0,999,1003,1009,1016 for multiple, where these numbers are the library IDs. No spaces.
//all indicates "all branches" (i.e. system-wide would be lib=all)
//Branch IDs start in the 1000s as show above. Your branch IDs may vary
//
//Branch List:
//999-All Locations
//1005-FORGE at the Hellmann Creative Center
//1000-Covington
//0-William E. Durr
//1001-Erlanger
//1004-Online
//1003-Off Site
//1002-Administration
//1006-Makerspace
$spacesXMLFilePending .= "&lib=" . $lib;

//Specific Spaces
//loc=
//7 - BB&T Meeting Room 2/3
//10- Conference Room 2
//11- Conference Room 1
//51- BB&T Meeting Room
//23- Computer Learning Center
//$spacesXMLFile .= "&loc=7,10,11,51,23";

//Reservation Status
// 0 = Pending
// 1 = Approved [Default]
$spacesXMLFilePending .= "&status=0";



//To see complete list of variables to add, visit
//http://kb.demcosoftware.com/article.php?id=720

$spacesDataPending2 = "";
$pendingReservationsOutput = "";

foreach(range(0, 60) as $do){
	
	$spacesXMLFilePending2 = $spacesXMLFilePending;
	$spacesXMLFilePending2 .= "&do=" . $do;	
	$pendingSpacesData = simplexml_load_string(preg_replace('/(<\?xml[^?]+?)utf-16/i', '$1utf-8', file_get_contents($spacesXMLFilePending2)));
	//$spacesDataPending2 .= simplexml_load_string(preg_replace('/^(<\?[xX][mM][lL]\s+[^\?\>]+encoding\s*=\s*([\'"]))utf-16\2/u','\1utf-8\2', file_get_contents($spacesXMLFilePending2)));
	
	foreach($pendingSpacesData->item as $space){
		$pendingReservationsOutput .= $space->location . ": " . $space->date . " - " . $space->time . "<br>\n";
	}
	
}


?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Display</title>
	<meta http-equiv="refresh" content="60">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<link rel="stylesheet" href="main.css">
</head>

<body>
	<div id="header">
		<h1>Erlanger Makerspace</h1>
	</div>
	<div id="left">
		<h2>Today's Reservations</h2>
		<?php
		foreach($spacesData->item as $space){
			echo $space->location . ": " . $space->time . " - " . $space->endtime . "<br>\n";
		}
		?>
	</div>
	
	<div id="right">
		<h2>Pending Reservations</h2>
		<?php
		echo $pendingReservationsOutput;
		?>
	</div>
</body>
</html>