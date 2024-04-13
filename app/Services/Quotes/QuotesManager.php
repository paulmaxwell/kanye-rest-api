<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesDriver;
use Illuminate\Support\Manager;

class QuotesManager extends Manager implements QuotesDriver
{
    public function createCacheDriver(): QuotesDriver
    {
        return new CacheDriver();
    }

    public function createApiDriver(): QuotesDriver
    {
        return new ApiDriver();
    }

    public function quotes(): array
    {
        return $this->driver()->quotes();
    }    

    public function getDefaultDriver()
    {
        return $this->config->get('quotes.driver', 'cache');
    }
}