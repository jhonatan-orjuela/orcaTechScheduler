<?php 
session_start();
require_once '../libs/google-api-php-client/src/Google/Client.php';
require_once '../libs/google-api-php-client/src/Google/Service/Calendar.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('OrCATek Scheduler');
$client->setClientId('377351928922-c771ed20ns780hbmv6cjebtrv9p7uqu6.apps.googleusercontent.com');
$client->setClientSecret('NVTXUL6Tjz6fnvji2HcwGngA');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyDdq77kaa9rk4yxyKeTR8DLZaCneDGKfQY'); // API key
$client->setScopes(array('https://www.googleapis.com/auth/plus.login'));
// $service implements the client interface, has to be set before auth call
$service = new Google_Service_Calendar($client);

echo var_dump($service);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
	die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
}
  $request = $_POST['storeToken'];
 
// Ensure that this is no request forgery going on, and that the user
// sending us this connect request is the user that was supposed to.
if ($request->get('state') != ($app['session']->get('state'))) {
	return new Response('Invalid state parameter', 401);
}

$code = $request->getContent();
$gPlusId = $request->get['gplus_id'];
// Exchange the OAuth 2.0 authorization code for user credentials.
$client->authenticate($code);

$token = json_decode($client->getAccessToken());
// Verify the token
$reqUrl = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' .
		$token->access_token;
$req = new Google_HttpRequest($reqUrl);

$tokenInfo = json_decode(
		$client::getIo()->authenticatedRequest($req)->getResponseBody());

// If there was an error in the token info, abort.
if ($tokenInfo->error) {
	return new Response($tokenInfo->error, 500);
}
// Make sure the token we got is for the intended user.
if ($tokenInfo->userid != $gPlusId) {
	return new Response(
			"Token's user ID doesn't match given user ID", 401);
}
// Make sure the token we got is for our app.
if ($tokenInfo->audience != CLIENT_ID) {
	return new Response(
			"Token's client ID does not match app's.", 401);
}

// Store the token in the session for later use.
$app['session']->set('token', json_encode($token));
$response = 'Succesfully connected with token: ' . print_r($token, true);

?>