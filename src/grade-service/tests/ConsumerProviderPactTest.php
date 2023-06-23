<?php

use PhpPact\Standalone\MockService\MockServer;
use PHPUnit\Framework\TestCase;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Standalone\MockService\MockServerEnvConfig;

class ConsumerProviderPactTest extends TestCase
{
    private $mockServer;

    protected function setUp(): void
    {
        $config = new \PhpPact\Standalone\MockService\MockServerConfig();
        $config
            ->setConsumer("someConsumer")
            ->setProvider("someProvider"); // Set the consumer name
            $config->setHost('localhost')
            ->setPort(7200);
            $config->setPactDir(__DIR__ . '/../../pact');
            $config->setHealthCheckTimeout(5000);
            $config->setHealthCheckRetrySec(5);

    $this->mockServer = new MockServer($config);
    $this->mockServer->start();
    }

    public function tearDown(): void
    {
        $this->mockServer->stop();
    }

    public function testProviderReturnsGrade()
    {
        $client = new \GuzzleHttp\Client();
        $config = new MockServerEnvConfig();
        $request = new ConsumerRequest();
        $request
        ->setMethod('GET')    
        ->setPath('/api/student-grades/1');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json');
            // ->setBody([
            //     'results' => $matcher->eachLike($category),
            // ]);
        // Menentukan kontrak PACT
        $interaction = new InteractionBuilder($config);
        $interaction
            ->given('Grade with ID 1 exists')
            ->uponReceiving('A request to get user details')
            ->with(
                new ConsumerRequest('GET', '/api/student-grades/1')
            )
            ->willRespondWith(
                new ProviderResponse(200, [], [
                        'id' => 1,
                        'student_user_id' => 7,
                        'assignment_id' => '1',
                        'published' => '1'
                ])
            );

        // Mengirimkan permintaan ke provider
        
        $response = $client->get('http://localhost:/student-grades/1');

        // Memeriksa respons sesuai dengan kontrak
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        // $this->assertEquals('John Doe', $data['name']);
        // $this->assertEquals('john.doe@example.com', $data['email']);

        // Memverifikasi kontrak dengan provider
        $this->mockServer->verifyInteractions();
    }
}
