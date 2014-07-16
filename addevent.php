<?php

$unixtime = strtotime($_POST['date']." ".$_POST['time']); 
$when = date("Y-m-d H:i:s", $unixtime);

$city = $_POST['title'];
$venue = $_POST['location'];
$address = '701 E Palm Canyon Dr, Palm Springs, CA 92264';
$desc = $_POST['description'];
$event_id = $_POST['id'];

error_log(print_r($_POST, true));

$data = array(
  'secret' => 'dc62c18b19b52c7727319870cd05c8a8815330d3',
  'when' => $when,
  'city' => $city,
  'state' => 'CA',
  'country' => 'US',
  'venue' => $venue,
  'address' => $address,
  'description' => $desc,
  'tickets_url' => '',
  'image_url' => '',
  'category_id' => '0'
  );

$coolguy = "create";

if (!empty($event_id)) {
  $data['id'] = $event_id;
  $data['show_id'] = $event_id;
  $coolguy = "update";
}


$handle = curl_init("https://mobileroadie.com/api/shows/".$coolguy."/key/6cc65181db2bc6bde/format/json");
curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

// this line returns the api call to a string
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($handle);
$http_status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
curl_close($handle);
error_log($response);

if ($http_status == '200') {
  $msg = "Success!";
  $err = 0;
} else {
  $msg = $response;
  $err = 1;
}

echo json_encode(array('upload' => array('data' => $_FILES, 'status' => http_response_code()), "error" => $err, 'message' => $msg ));

?>
