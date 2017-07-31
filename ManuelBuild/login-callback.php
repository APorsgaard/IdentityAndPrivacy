<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '2037005676527770',
  'app_secret' => '9c9398cf0fc8a4a03278bee46979701a',
  'default_graph_version' => 'v2.10'
]);
$helper = $fb->getJavaScriptHelper();
try {
  $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}
if (isset($accessToken)) {
   $fb->setDefaultAccessToken($accessToken);
  try {
  
    $requestProfile = $fb->get("/me?fields=name,email");
    $profile = $requestProfile->getGraphNode()->asArray();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
  }
  
  setcookie('name', $profile['name'], time() + (3600*2), "/");
  header('location: ../');
  exit;
} else {
    echo "Unauthorized access!!!";
    exit;
}