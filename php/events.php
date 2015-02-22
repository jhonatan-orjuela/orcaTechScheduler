<?php
	require_once '../libs/google-api-php-client/autoload.php';
	require_once '../libs/google-api-php-client/src/Google/Client.php';
	require_once '../libs/google-api-php-client/src/Google/Service/Calendar.php';
	require_once '../libs/smarty/libs/Smarty.class.php';
	
	$client = new Google_Client();
	$calendar = new Google_Service_Calendar($client);
	
	$smarty = new Smarty();
	
	$smarty->assign('event', 'EVENT');
	
	$smarty->display('../tpl/events.tpl');
?>