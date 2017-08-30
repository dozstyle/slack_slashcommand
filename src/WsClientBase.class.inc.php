<?php
  namespace DozStyle;

  abstract class WsClientBase
  {
    protected $curl_client;
    protected $resp;

    public function __construct($curl_client) {
      $this->curl_client = $curl_client;
      $this->setDefaultOptions();
    }

    protected function setTimeout($timeout) {
      curl_setopt($this->curl_client, CURLOPT_URL, $timeout);
    }

    protected function post($func, $url, $header = array(), $data = array()) {
      curl_setopt($this->curl_client, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($this->curl_client, CURLOPT_URL, $url); 
      curl_setopt($this->curl_client, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($this->curl_client, CURLOPT_HTTPHEADER, $header);
      curl_setopt($this->curl_client, CURLOPT_POSTFIELDS, $data);

      $response = curl_exec($this->curl_client);
      $info = curl_error($this->curl_client);
      error_log(print_r($info, true));

      $this->prepareResult($response);
    }

    protected function get($func, $url, $header = array(), $data = array()) {
      curl_setopt($this->curl_client, CURLOPT_CUSTOMREQUEST, 'GET');
      curl_setopt($this->curl_client, CURLOPT_URL, $url);
      curl_setopt($this->curl_client, CURLOPT_HTTPHEADER, $header);
      curl_setopt($this->curl_client, CURLOPT_POSTFIELDS, $data);

      $response = curl_exec($this->curl_client);
      $this->prepareResult($response);
    }

    private function prepareResult($response) {
        $resp_code = curl_getinfo($this->curl_client, CURLINFO_HTTP_CODE);
        if (($resp_code >= 500 && $resp_code <= 530) || $resp_code == 401 || $resp_code == 403) {
          error_log(print_r($response, true));
        } else if ($resp_code >= 300 && $resp_code < 500) {
          error_log(print_r($response, true));
        } else {
          error_log(print_r($response, true));
        }
    }

    private function setDefaultOptions() {
      # disable ssl verification by default
      curl_setopt($this->curl_client, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($this->curl_client, CURLOPT_SSL_VERIFYPEER, 0);
    }
  }
 ?>
