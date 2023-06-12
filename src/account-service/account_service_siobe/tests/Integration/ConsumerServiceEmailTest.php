<?php

namespace Tests\Integration;

use App\OutsideAPI\ProviderOne\HttpEmailService;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class ConsumerServiceEmailTest extends TestCase
{

    public function test_using_email_service_is_successful()
    {
        $matcher = new Matcher();

        //expected request from the consumer.
        $request = new ConsumerRequest();
        $request
            ->setMethod('POST')
            ->setPath('/emails')
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'to'=> ['recipient1@example.com'],
                'subject' => 'Verify Email Address OR Reset Password',
                'text' => 'auto_generated_link THIS EMAIL VERIFICATION LINK WILL EXPIRED IN 60 MINUTES'
            ]);

        //expected response from the provider.
        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'status' => 'success',
                'message' => 'email sent',
            ]);

        // Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A post request to /emails')
            ->with($request)
            ->willRespondWith($response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

        $service = new HttpEmailService($config->getBaseUri()); // Pass in the URL to the Mock Server.
        $result  = $service->getEmailResponse(); // Make the real API request against the Mock Server.

        $builder->verify(); // This will verify that the interactions took place.

        $expectedResult = ([
            'status' => 'success',
            'message' => 'email sent',
        ]);

        $this->assertEquals($expectedResult, $result);   

        // Make your assertions.
    }
}