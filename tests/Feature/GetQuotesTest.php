<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetQuotesTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_200_for_correct_api_token(): void
    {
        $token = 'test-token';
        $hash = hash('sha256', $token);
        $this->createUser(['api_token' => $hash]);

        $response = $this->get('/api/quotes', ['Authorization' => $token]);

        $response->assertStatus(200);
    }

    public function test_returns_401_for_incorrect_api_token(): void
    {
        $token = 'test-token';
        $this->createUser(['api_token' => $token]);

        $response = $this->get('/api/quotes', ['Authorization' => 'incorrect-token']);

        $response->assertStatus(401);
    }

    public function test_returns_401_for_missing_api_token(): void
    {
        $token = 'test-token';
        $this->createUser(['api_token' => $token]);

        $response = $this->get('/api/quotes');

        $response->assertStatus(401);
    }
}
