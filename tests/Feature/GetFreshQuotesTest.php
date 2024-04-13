<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetFreshQuotesTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_200_for_correct_api_token(): void
    {
        $token = 'test-token';
        $hash = hash('sha256', $token);
        $this->createUser(['api_token' => $hash]);

        $response = $this->get('/api/fresh-quotes', ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_returns_401_for_incorrect_api_token(): void
    {
        $token = 'test-token';
        $this->createUser(['api_token' => $token]);

        $response = $this->get('/api/fresh-quotes', ['Authorization' => 'Bearer incorrect-token']);

        $response->assertStatus(401);
    }

    public function test_returns_401_for_missing_api_token(): void
    {
        $token = 'test-token';
        $this->createUser(['api_token' => $token]);

        $response = $this->get('/api/fresh-quotes');

        $response->assertStatus(401);
    }

    public function test_returns_and_refreshes_quotes_if_already_cached(): void
    {
        $token = 'test-token';
        $hash = hash('sha256', $token);
        $this->createUser(['api_token' => $hash]);

        $cachedQuotes = [
            'cached-quote-1',
            'cached-quote-2',
            'cached-quote-3',
            'cached-quote-4',
            'cached-quote-5',
        ];
        Cache::put('quotes', $cachedQuotes);

        $mockApiQuotes = [
            'mocked-api-quote-1',
            'mocked-api-quote-2',
            'mocked-api-quote-3',
            'mocked-api-quote-4',
            'mocked-api-quote-5',
        ];
        Http::fake([
            'https://api.kanye.rest' => function () use ($mockApiQuotes) {
                static $quoteIndex = 0;
                $quote = $mockApiQuotes[$quoteIndex];
                $quoteIndex++;
                return Http::response(['quote' => $quote], 200);
            },
        ]);

        $response = $this->get('/api/fresh-quotes', ['Authorization' => 'Bearer ' . $token]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals($data, $mockApiQuotes);
        $this->assertEquals(Cache::get('quotes'), $mockApiQuotes);
    }

    public function test_returns_and_refreshes_quotes_if_none_cached(): void
    {
        $token = 'test-token';
        $hash = hash('sha256', $token);
        $this->createUser(['api_token' => $hash]);

        $mockApiQuotes = [
            'mocked-api-quote-1',
            'mocked-api-quote-2',
            'mocked-api-quote-3',
            'mocked-api-quote-4',
            'mocked-api-quote-5',
        ];
        Http::fake([
            'https://api.kanye.rest' => function () use ($mockApiQuotes) {
                static $quoteIndex = 0;
                $quote = $mockApiQuotes[$quoteIndex];
                $quoteIndex++;
                return Http::response(['quote' => $quote], 200);
            },
        ]);

        $response = $this->get('/api/fresh-quotes', ['Authorization' => 'Bearer ' . $token]);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals($data, $mockApiQuotes);
        $this->assertEquals(Cache::get('quotes'), $mockApiQuotes);
    }
}
