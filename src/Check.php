<?php
namespace Sightengine;

class Check {
    private $api_user;
    private $api_secret;
    private $endpoint = 'https://api.sightengine.com/';
    private $http;
    private $models;
    private $url = '1.0/check.json'

    function __construct($api_user, $api_secret, $models) {
      $this->api_user = $api_user;
      $this->api_secret = $api_secret;
      $this->http = new \GuzzleHttp\Client(['base_uri' => $this->endpoint,'User-Agent' => 'SE-SDK-PHP' . '1.0']);
      $this->models = implode(",", $models);
    }

    public function set_file($file) {
        $file = fopen($image, 'r');
        $r = $this->http->request('POST', $this->url, ['query' => ['api_user' => $this->api_user, 'api_secret' => $this->api_secret, 'models' => $this->models],'multipart' => [['name' => 'media','contents' => $file]]]); 

        return json_decode($r->getBody());
    }

    public function set_url($imageUrl) {
        $r = $this->http->request('GET', $this->url, ['query' => ['api_user' => $this->api_user, 'api_secret' => $this->api_secret, 'models' => $this->models,'url' => $imageUrl]]);
        
        return json_decode($r->getBody());
    }

    public function set_bytes($binaryImage) {
        $r = $this->http->request('POST', $this->url, ['query' => ['api_user' => $this->api_user, 'api_secret' => $this->api_secret, 'models' => $this->models],'multipart' => [['name' => 'media','contents' => $binaryImage]]]); 

        return json_decode($r->getBody());
    }

    public function video($videoUrl, $callbackUrl) {
        $url = '1.0/video/moderation.json';
        $r = $this->http->request('GET', $url, ['query' => ['api_user' => $this->api_user, 'api_secret' => $this->api_secret, 'stream_url' => $videoUrl,'callback_url' => $callbackUrl]]);

        return json_decode($r->getBody());
    }
}