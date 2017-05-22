<?php
  if(isset($_GET['code'])) {
	  function getCurlValue($filename, $contentType, $postname)
{
    // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
    // See: https://wiki.php.net/rfc/curl-file-upload
    if (function_exists('curl_file_create')) {
        return curl_file_create($filename, $contentType, $postname);
    }
 
    // Use the old style if using an older version of PHP
    $value = "@{$filename};filename=" . $postname;
    if ($contentType) {
        $value .= ';type=' . $contentType;
    }
 
    return $value;
}
 
  $code = $_GET['code'];
$filename = 'extension.zip';
$cfile = getCurlValue($filename,'application/zip','extension.zip');
 
//NOTE: The top level key in the array is important, as some apis will insist that it is 'file'.
$data = array('file' => $cfile);

$ch = curl_init();
$options = array(CURLOPT_URL => 'https://www.googleapis.com/upload/chromewebstore/v1.1/items',
             CURLOPT_RETURNTRANSFER => true,
             CURLINFO_HEADER_OUT => true, //Request header
             CURLOPT_HEADER => false, //Return header
             CURLOPT_SSL_VERIFYPEER => false, //Don't veryify server certificate
             CURLOPT_POST => true,
             CURLOPT_POSTFIELDS => $data
            );
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Authorization: Bearer '. $code . '', 'x-goog-api-version: 2'));
curl_setopt_array($ch, $options);
  $json_response = curl_exec($ch);
  $authObj = json_decode($json_response);
  $id = $authObj->id;
  //echo $id;
  echo 'Edit Extension: <a target="_blank" href="https://chrome.google.com/webstore/developer/edit/'. $id . '">Edit Extension</a>';
  echo '</br>';
  echo 'Publish Extension: <a target="_blank" href="https://publish99.herokuapp.com/publish/publish.php?code=' . $code . '&id=' . $id . '">Publish Extension</a>';
 
  curl_close($ch);

  }
?>