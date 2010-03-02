<?php
 require_once "iwiwconnecthelper.php";

 // the application consumerKey and consumerSecret
// $consumerKey='08254caeb237b367b8df1dc803f582bcedbd854c';
// $consumerSecret='9d997e79062280733b12085e57c884894c385572'; 
 $consumerKey='klucs';
 $consumerSecret='titkos_kulcs';

 // iwiw url eg. sandbox.iwiw.hu, approval.iwiw.hu, iwiw.hu
 $iwiwBaseURL = 'http://approval.iwiw.hu';
 
 // iwiw Api url eg. api.sandbox.iwiw.hu, api.approval.iwiw.hu, api.iwiw.hu
 $iwiwBaseApiURL = 'http://api.approval.iwiw.hu';
 	
 $osapi = initIWIWConnect($consumerKey, $consumerSecret, $iwiwBaseURL, $iwiwBaseApiURL);

 if (osapi){
 	 
 	$result = getSelfAndFriends($osapi);
 	printResult("<h2>Friend List</h2>", $result);
	
 	$result = createActivity($osapi, 'testtitle', 'testvalue '.time());
 	printResult("<h2>Create Activity</h1>", $result);
 	
 	$result = createMessage($osapi, array(9612288), 'testbody'.time());
 	printResult("<h2>Create Message</h1>", $result);

 } else {
 	echo "Error connecting to IWIW !";
 }

 function printResult($header, $result) {
 	echo $header;
 	foreach ($result as $key => $result_item) {
 		if ($result_item instanceof osapiError) {
 			$code = $result_item->getErrorCode();
 			$message = $result_item->getErrorMessage();
 			echo "<h3>There was a <em>$code</em> error with the <em>$key</em> request:</h3>";
 			echo "<pre>";
 			echo htmlentities($message);
 			echo "</pre>";
 		} else {
 			echo "<h3>Response for the <em>$key</em> request:</h3>";
 			echo "<pre>";
 			echo htmlentities(print_r($result_item, True));
 			echo "</pre>";
 		}
  }
 }

