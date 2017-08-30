<?php
require('./SlackApiClient.class.inc.php');

### ensure all required POST fields are existed
if ( empty($_POST['team_domain']) || empty($_POST['team_id']) ||
     empty($_POST['channel_id'])  || empty($_POST['token'])   ||
     empty($_POST['command'])     || empty($_POST['text'])    ||
     empty($_POST['user_name'])) {
  die();
} else {
  $team_domain = $_POST['team_domain'];
  $team_id     = $_POST['team_id'];
  $channel     = $_POST['channel_id'];
  $token       = $_POST['token'];
  $command     = $_POST['command'];
  $text        = $_POST['text'];
  $user_name   = $_POST['user_name'];
}

# verify tocken is correct
if (! $token == '{Your Verification Token' ) {
  error_log('Verification Token Verfied Error' . $token);
  # this meesage will go back to the user
  die('Verification Token Verified Fail');
}

error_log(print_r($_POST, true));

$oauth_token = '{Your OAuth Token}';

$client = new \Slack\SlackApiClient();

switch($command) {
  case '/code':
    $client->uploadFile($oauth_token, $text, $channel);
  break;

  case '/codetype':
    # get languange
    $first_line = strtok(trim($text), "\r\n");
    $first_line_arr = explode($first_line, ' ');
    if ( empty($first_line_arr[0]) || $first_line_arr[0] == ' ' ) {
      $lang = $first_line;
    } else {
      $lang = $first_line_arr[0];
    }

    # remove lang declaration from original message
    $pattern = '/' . $lang . '/';
    $substr = preg_replace($pattern, '', $text, 1);

    # remove first empty line
    $substr = preg_replace("/^[\r\n]*/", "", $substr);
    $client->uploadFile($oauth_token, $substr, $channel, $lang);
  break;

  case '/text':
    $text = '```' . $text . '```';
    $client->sendMessage($oauth_token, $text, $channel, true, $user_name);
  break;
}
?>
