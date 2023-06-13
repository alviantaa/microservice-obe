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

class CourseClassConsumerTest extends TestCase
{
    /**
     * Example PACT test.
     *
     * @throws \Exception
     */
    public function testGetCourseClassData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('GET')
            ->setPath('/api/course-class')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => $matcher->eachLike([
                    'id' => 1,
                    'course_id' => 5,
                    'name' => 'Pemrograman Web Lanjut A',
                    'class_code' => 'PWL-A',
                    'thumbnail_img' => 'https://via.placeholder.com/640x480.png/000088?text=cats',
                    'creator_user_id' => 1,
                    'syllabus_id' => 1
                ])
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A get request to /api/course-class')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->getCourseClassData('Course Class');

        $builder->verify();

        $this->assertEquals('{"message":[{"id":1,"course_id":5,"name":"Pemrograman Web Lanjut A","class_code":"PWL-A","thumbnail_img":"https://via.placeholder.com/640x480.png/000088?text=cats","creator_user_id":1,"syllabus_id":1}]}', $result);
    }

    public function testPostCourseClassData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('POST')
            ->setPath('/api/course-class')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => $matcher->eachLike([
                    'id' => 1,
                    'course_id' => 5,
                    'name' => 'Pemrograman Web Lanjut A',
                    'class_code' => 'PWL-A',
                    'thumbnail_img' => 'https://via.placeholder.com/640x480.png/000088?text=cats',
                    'creator_user_id' => 1,
                    'syllabus_id' => 1
                ])
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A post request to /api/course-class')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->postCourseClassData('Course Class');

        $builder->verify();

        $this->assertEquals('{"message":[{"id":1,"course_id":5,"name":"Pemrograman Web Lanjut A","class_code":"PWL-A","thumbnail_img":"https://via.placeholder.com/640x480.png/000088?text=cats","creator_user_id":1,"syllabus_id":1}]}', $result);
    }

    public function testDeleteCourseClassData()
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setMethod('DELETE')
            ->setPath('/api/course-class/1')
            ->addHeader('Content-Type', 'application/json');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'message' => 'Course class deleted'
            ]);

        $config  = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A delete request to /api/course-class/1')
            ->with($request)
            ->willRespondWith($response);

        $service = new HttpClientService($config->getBaseUri());
        $result  = $service->deleteCourseClassData('Course Class');

        $builder->verify();

        $this->assertEquals('{"message":"Course class deleted"}', $result);
    }
}
