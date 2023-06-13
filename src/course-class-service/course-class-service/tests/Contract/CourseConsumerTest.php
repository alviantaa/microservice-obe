<?php

namespace Tests\Contract;

use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;
use App\OutsideAPI\HttpClientService;
use PhpPact\Standalone\MockService\MockServerConfig;
use PhpPact\Standalone\MockService\MockServer;

class CourseConsumerTest extends TestCase
{
    /**
     * Example PACT test.
     *
     * @throws \Exception
     */
    public function testGetCourseData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath('/api/course')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => $matcher->eachLike([
                    'id' => 1,
                    'study_program_id' => 1,
                    'creator_user_id' => 1,
                    'name' => 'Pemrograman Web Lanjut',
                    'code' => 'A123',
                    'course_credit' => 3,
                    'lab_credit' => 1,
                    'type' => 'mandatory',
                    'short_description' => 'Pemrograman Web Tingkat Lanjut',
                    'minimal_requirement' => 'Pemrograman Web',
                    'study_material' => 'laravel',
                    'learning_media' => 'slack',
                ])
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A get request to /api/course')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->getCourseData('Course');

        $builder->verify();

        $this->assertEquals('{"message":[{"id":1,"study_program_id":1,"creator_user_id":1,"name":"Pemrograman Web Lanjut","code":"A123","course_credit":3,"lab_credit":1,"type":"mandatory","short_description":"Pemrograman Web Tingkat Lanjut","minimal_requirement":"Pemrograman Web","study_material":"laravel","learning_media":"slack"}]}', $result);
    }

    public function testPostCourseData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('POST')
            ->setPath('/api/course')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => $matcher->eachLike([
                    'id' => 1,
                    'study_program_id' => 1,
                    'creator_user_id' => 1,
                    'name' => 'Pemrograman Web Lanjut',
                    'code' => 'A123',
                    'course_credit' => 3,
                    'lab_credit' => 1,
                    'type' => 'mandatory',
                    'short_description' => 'Pemrograman Web Tingkat Lanjut',
                    'minimal_requirement' => 'Pemrograman Web',
                    'study_material' => 'laravel',
                    'learning_media' => 'slack',
                ])
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A post request to /api/course')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->postCourseData('Course');

        $builder->verify();

        $this->assertEquals('{"message":[{"id":1,"study_program_id":1,"creator_user_id":1,"name":"Pemrograman Web Lanjut","code":"A123","course_credit":3,"lab_credit":1,"type":"mandatory","short_description":"Pemrograman Web Tingkat Lanjut","minimal_requirement":"Pemrograman Web","study_material":"laravel","learning_media":"slack"}]}', $result);
    }

    public function testDeleteCourseData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('DELETE')
            ->setPath('/api/course/1')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => 'Course deleted'
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A delete request to /api/course/1')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->deleteCourseData('Course');

        $builder->verify();

        $this->assertEquals('{"message":"Course deleted"}', $result);
    }
}
