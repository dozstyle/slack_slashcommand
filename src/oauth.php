<?php

$client_id = '230291504775.230730496598';
$client_secret = '{YOUR SECRET}';
$code = $_REQUEST['code'];

# https://#{team}.slack.com/api/oauth.access?client_id=#{cid}&client_secret=#{cs}&code=#{code}"
$url = "https://slack.com/api/oauth.access?client_id=$client_id&client_secret=$client_secret&code=$code";
$client = curl_init();
error_log($url);
curl_setopt($client, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($client, CURLOPT_URL, $url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);
error_log(print_r($response, true));

header("Location: https://slack.com/apps/A6SMGELHL");
exit();
?>
