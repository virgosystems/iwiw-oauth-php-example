<?php
 /*
  *  please set the include path to include the osapi-php library
  *  more info:   http://code.google.com/p/opensocial-php-client/
  * 
  */

 require_once 'osapi.php';
 require_once 'osapiIwiwProvider.php';
 require_once 'osapiOAuth3Legged_10a_iwiw.php';

 /**
  * configures and initializes the osapi object
  *
  * @return osapi object
  */
 function initIWIWConnect($consumerKey, $consumerSecret, $iwiwBaseURL = "http://iwiw.hu", $iwiwBaseApiURL = "http://api.iwiw.hu") {
 	
 	// Log
 	osapiLogger::setLevel(osapiLogger::INFO);
 	osapiLogger::setAppender(new osapiFileAppender("/tmp/logs/osapi.log"));
 
 	// Create an identifier for the local user's session
	session_start();
 	$localUserId = session_id();
 	
 	//The persistent storage
 	$storage = new osapiFileStorage('/tmp/osapistorage');
 	//$storage = new osapiMemcacheStorage('127.0.0.1','11211');
 	
 	//the iwiw provider
 	$provider = new osapiIwiwProvider($iwiwBaseURL, $iwiwBaseApiURL);
 	
 	$auth = osapiOAuth3Legged_10a_iwiw::performOAuthLogin($consumerKey, $consumerSecret, $storage, $provider, $localUserId);
 	$osapi = new osapi($provider, $auth);
 	
 	return $osapi;  	
 }
 
 
 /**
  * Returns profile info and friends list
  *
  * @param osapi $osapi
  * @param $userId
  * @return batch result
  */
 function getSelfAndFriends(osapi $osapi, $userId = '@me') {
 	
 	//the supported fields
 	$profile_fields = array(
        'name',
        'displayName',       
        'currentLocation',
 		'isOwner',
 		'isViewer'        
 		);

 	// The number of friends to fetch.
 	$friend_count = 2;

 	// Start a batch so that many requests may be made at once.
 	$batch = $osapi->newBatch();

 	// Fetch the current user.
 	$self_request_params = array(
      'userId' => $userId,              // Person we are fetching.
      'groupId' => '@self',             // @self for one person.
      'fields' => $profile_fields       // Which profile fields to request.
 	);
 	$batch->add($osapi->people->get($self_request_params), 'self');

 	// Fetch the friends of the user
 	$friends_request_params = array(
      'userId' => $userId,              // Person whose friends we are fetching.
      'groupId' => '@friends',          // @friends for the Friends group.
      'fields' => $profile_fields,      // Which profile fields to request.
      'count' => $friend_count          // Max friends to fetch.
 	);
 	$batch->add($osapi->people->get($friends_request_params), 'friends');

 	// Send the batch request.
 	$result = $batch->execute();
     
 	return $result;
 }
 
 /**
  * creates an activity
  *
  * @param osapi $osapi
  * @param $templateId
  * @param array $templateParams
  * @param $userId
  * @return unknown
  */
 function createActivity(osapi $osapi, $title, $body, $userId = '@me', $appId = '@app') {
 	
  $batch = $osapi->newBatch();
  	
  $activity = new osapiActivity();
   
  $activity->setField('title', $title);
  $activity->setField('body', $body);
 
  $create_params = array(
      'userId' => $userId,
      'groupId' => '@self',
      'activity' => $activity,
      'appId' => $appId
  );
  $batch->add($osapi->activities->create($create_params), 'createActivity');
  
  return $batch->execute();
 }
 
 
 /**
  * creates a message
  *
  * @param osapi $osapi
  * @param  $recipients array of recipient ids
  * @param  $title 
  * @param  $body
  * @param  $userid
  */
 function createMessage(osapi $osapi, $recipients, $body, $userId = '@me') {

  $batch = $osapi->newBatch();

  // Create a message, title not supported
  $message = new osapiMessage($recipients, $body, '' );
  $create_params = array(
      'userId' => $userId, 
      'groupId' => '@self', 
      'message' => $message
  );
  $batch->add($osapi->messages->create($create_params), 'createMessage');

  // Send the batch request.
  $result = $batch->execute();
  return $result;
 }
