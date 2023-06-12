<?php

namespace Consumer\Service;

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;
use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Consumer\ConsumerBuilder;

class ConsumerServiceHelloTest extends TestCase
{
	/**
	 * Example PACT test.
	 *
	 * @throws \Exception
	 */

	protected static $pactMockServer;

	public static function setUpBeforeClass(): void
	{
		$config = new MockServerConfig();
		$config->setHost('localhost');
		$config->setPort(8000);
		$config->setConsumer('Syllabus');
		$config->setProvider('User');

		self::$pactMockServer = new MockServer($config);
		self::$pactMockServer->start();
	}

	public static function tearDownAfterClass(): void
	{
		self::$pactMockServer->stop();
	}
	public function testGetHelloString()

	{
		$matcher = new Matcher();

		$request = new ConsumerRequest();
		$request
			->setMethod('GET')
			->setPath('/api/syllabi')
			->addHeader('Content-Type', 'application/json');

		$response = new ProviderResponse();
		$response
			->setStatus(200)
			->addHeader('Content-Type', 'application/json')
			->setBody([
				'list' => $matcher->eachLike([
                    'id' => 1,
                    'course' => 'Microservice',
                    'title' => 'MA',
                    'author' => 'Andrisan',
                    'head_of_study_program' => 'Issa Arwani',
                    'creator_user_id' => 123456,
                ])
			]);

		// Create a configuration that reflects the server that was started. You can create a custom MockServerConfigInterface if needed.
		$config  = new MockServerEnvConfig();
		$builder = new InteractionBuilder($config);
		$builder
			->uponReceiving('A Get request to /syllabi')
			->with($request)
			->willRespondWith($response); // This has to be last. This is what makes an API request to the Mock Server to set the interaction.

		$service = new HttpClientService($config->getBaseUri()); // Pass in the URL to the Mock Server.
		$result  = $service->getHelloString('Reza'); // Make the real API request against the Mock Server.

		$builder->verify(); // This will verify that the interactions took place.

		$this->assertEquals('Succesfully create syllabus', $result); // Make your assertions.
	}
}