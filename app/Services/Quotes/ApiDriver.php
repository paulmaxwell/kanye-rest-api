<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesDriver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiDriver implements QuotesDriver
{
    public function quotes(): array
    {
        $quotes = $this->getQuotesFromApi();
        Cache::put('quotes', $quotes);
        return $quotes;
    }

    private function getQuotesFromApi()
    {
        $quotes = [];

        for ($i = 0; $i < 5; $i++) {
            $response = Http::get('https://api.kanye.rest');
            $quote = $response->json()['quote'];
            $quotes[] = $quote;
        }

        return $quotes;
    }
}