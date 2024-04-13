<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesDriver;

class ApiDriver implements QuotesDriver
{
    public function quotes(): array
    {
        return [];
    }
}