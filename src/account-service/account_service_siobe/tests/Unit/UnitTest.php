<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{

    public function test_automatic_link_generation_is_successfull(): void
    {
        $p = "";
        $link = "http://127.0.0.1:8000/api/auth/verify-email?token=";
        $token = "generated_jwt_token_for_authentication";
        $generatedlink = implode($p, array($link, $token));
        $expectedLink = "http://127.0.0.1:8000/api/auth/verify-email?token=generated_jwt_token_for_authentication";

        $this -> assertEquals($generatedlink, $generatedlink);
    }

    public function test_requested_ids_is_successfull(): void
    {
        $request = "1-2-3-4-5";
        $ids = explode('-', $request);

        $this->assertIsArray($ids);
        $this->assertCount(5, $ids);
        $this->assertEquals('1', $ids[0]);
        $this->assertEquals('2', $ids[1]);
        $this->assertEquals('3', $ids[2]);
        $this->assertEquals('4', $ids[3]);
        $this->assertEquals('5', $ids[4]);
    }
}
