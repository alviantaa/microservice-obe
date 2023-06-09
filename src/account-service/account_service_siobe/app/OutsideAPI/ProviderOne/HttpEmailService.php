<?php

namespace App\OutsideAPI\ProviderOne;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class HttpEmailService
{
    private Client $httpClient;

    private string $baseUri;

    public function __construct(string $baseUri)
    {
        $this->httpClient = new Client();
        $this->baseUri    = $baseUri;
    }

    public function getEmailResponse()
    {
        $response = $this->httpClient->post(new Uri("{$this->baseUri}/emails"), [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'to' => ['recipient1@example.com'],
                'subject' => 'Verify Email Address OR Reset Password',
                'text' => 'auto_generated_link THIS EMAIL VERIFICATION LINK WILL EXPIRED IN 60 MINUTES',
            ],
        ]);
        
        $body = $response->getBody()->getContents();
        $object = json_decode($body, true);

        return $object;

        // $object = $response->\json_decode([
        //     'status' => 'success',
        //     'message' => 'email sent',
        // ]);

        // return $object;
    }
}