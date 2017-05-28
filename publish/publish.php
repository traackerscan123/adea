<?php
if(isset($_GET['code'])) {
  $code = $_GET['code'];
  $id = $_GET['id'];
  $url = 'https://www.googleapis.com/chromewebstore/v1.1/items/'. $id .'/publish';
  $params = array(
    "itemId" => $id,
    "publishTarget" => "default"
  );
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $code . '',
    'x-goog-api-version: 2',
    'Content-Length: 0'
    ));
  curl_setopt($curl, CURLOPT_POST, true);
  //($curl, CURLOPT_POSTFIELDS, $params);                                                
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
  $json_response = curl_exec($curl);
  echo $json_response;
  curl_close($curl);

}
?>