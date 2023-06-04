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

        $this -> assertEquals("http://127.0.0.1:8000/api/auth/verify-email?token=generated_jwt_token_for_authentication", $generatedlink);
    }
}
