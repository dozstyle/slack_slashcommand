<?php
  namespace Slack;

  require_once('./WsClientBase.class.inc.php');

  use \DozStyle;

  require_once('./WsClientBase.class.inc.php');

  class SlackApiClient extends \DozStyle\WsClientBase
  {
    private $req;
    private $url_base = 'https://slack.com/api';
    protected $curl_client;
    private $curl_timedout = 20;

    public function __construct() {
      //$this->loadConfig();
      $this->curl_client = curl_init();
      $this->setTimeout($this->curl_timedout);
      parent::__construct($this->curl_client);
    }

    public function uploadFile($token, $input, $channels, $type = 'auto', $title = '', $filename = '') {
      # https://api.slack.com/methods/files.upload
      $path = '/files.upload';
      $url  = $this->url_base . $path;
      $header = array(
        'Content-type: multipart/form-data'
      );
      $data = array(
        'token' => $token,
        'content' => html_entity_decode(htmlspecialchars_decode($input, ENT_QUOTES)),
        'filetype' => $type,
        'channels' => $channels,
        'title' => $title,
        'filename' => $filename
      );
      $this->post(__FUNCTION__, $url, $header, $data);
    }

    public function sendMessage($token, $text, $channel, $as_user = false, $user_name = 'slashcode', $attachments = '' ,$icon_emoji = '') {
      # https://api.slack.com/methods/chat.postMessage
      $path = '/chat.postMessage';
      $url = $this->url_base . $path;
      $header = array(
        'Content-type: multipart/form-data'
      );
      $data = array(
        'token' => $token,
        'channel' => $channel,
        'text' => html_entity_decode(htmlspecialchars_decode($text, ENT_QUOTES)),
        'attachments' => $attachments,
        'as_user' => $as_user,
        'username' => $bot_name,
        'icon_emoji' => $icon_emoji
      );
      $this->post(__FUNCTION__, $url, $header, $data);
    }
  }
