<?php
$url = "https://accounts.google.com/o/oauth2/auth";
$client_id = "521215438731-e6sad8qr4ssia6o1ul7sjrvk8hj388f4.apps.googleusercontent.com";
$client_secret = "uESUEEGnj5tr_7jg8qH0bbmT";
$redirect_uri = "http://publish99.herokuapp.com/publish/start.php";
$access_type = "offline";
$approval_prompt = "force";
$grant_type = "authorization_code";
$scope = "https://www.googleapis.com/auth/chromewebstore";
$params_request = array(
  "response_type" => "code",
  "client_id" => "$client_id",
  "redirect_uri" => "$redirect_uri",
  "access_type" => "$access_type",
  "approval_prompt" => "$approval_prompt",
  "scope" => "$scope"
  );
$request_to = $url . '?' . http_build_query($params_request);
if(isset($_GET['code'])) {
  // try to get an access token
  $code = $_GET['code'];
  $url = 'https://accounts.google.com/o/oauth2/token';
  $params = array(
    "code" => $code,
    "client_id" => "$client_id",
    "client_secret" => "$client_secret",
    "redirect_uri" => "$redirect_uri",
    "grant_type" => "$grant_type"
  );
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
  $json_response = curl_exec($curl);
  curl_close($curl);
  $authObj = json_decode($json_response);
  //echo "Refresh token: " . $authObj->refresh_token;

  //echo "\nAccess token: " . $authObj->access_token;
  $token = $authObj->access_token;
  echo '<script> top.location.href = "http://publish99.herokuapp.com/publish/upload.php?code='.$authObj->access_token.'"; </script>';

}
header("Location: " . $request_to);
?>