<?php

namespace App\OutsideAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

/**
 * Example HTTP Service
 */
class HttpClientService
{
    private Client $httpClient;

    private string $baseUri;

    public function __construct(string $baseUri)
    {
        $this->httpClient = new Client();
        $this->baseUri    = $baseUri;
    }

    /**
     * Get Course Data
     */
    public function getCourseData(string $name): string
    {
        $response = $this->httpClient->get(new Uri("{$this->baseUri}/api/course"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }

    /**
     * Post Course Data
     */
    public function postCourseData(string $name): string
    {
        $response = $this->httpClient->post(new Uri("{$this->baseUri}/api/course"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }

    /**
     * Delete Course Data
     */
    public function deleteCourseData(string $name): string
    {
        $response = $this->httpClient->delete(new Uri("{$this->baseUri}/api/course/1"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }

    /**
     * Get Course Class Data
     */
    public function getCourseClassData(string $name): string
    {
        $response = $this->httpClient->get(new Uri("{$this->baseUri}/api/course-class"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }

    /**
     * Post Course Class Data
     */
    public function postCourseClassData(string $name): string
    {
        $response = $this->httpClient->post(new Uri("{$this->baseUri}/api/course-class"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }

    /**
     * Delete Course Class Data
     */
    public function deleteCourseClassData(string $name): string
    {
        $response = $this->httpClient->delete(new Uri("{$this->baseUri}/api/course-class/1"), [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        $object = \json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        $array = array($body);
        $name = implode("<br>", $array);

        return $name;
    }
}
