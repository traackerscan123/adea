<?php
$url = "https://accounts.google.com/o/oauth2/auth";
$client_id = "588189188538-c3qkvoubj3i6pr64u32g2et4iahmbn0k.apps.googleusercontent.com";
$client_secret = "mLd_oS7WND2cwKPLP9haWKSg";
$redirect_uri = "https://publish99.herokuapp.com/publish/upload.php";
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
  echo '<script> top.location.href = "https://publish99.herokuapp.com/publish/upload.php?code='.$authObj->access_token.'"; </script>';

}
header("Location: " . $request_to);
?>