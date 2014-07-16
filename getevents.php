<?php

// set HTTP header
$headers = array(
'Content-Type: application/json',
);

$url = "http://mobileroadie.com/api/shows/getAll/key/6cc65181db2bc6bde/range/future/format/json";

$handle = curl_init();

curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, false);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($handle);

curl_close($handle); 

echo $response;
?>