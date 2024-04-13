<?php

namespace App\Http\Controllers;

use App\Services\Quotes\QuotesManager;

class QuotesController extends Controller
{
    public function index()
    {
        return app(QuotesManager::class)->quotes('cache');
    }

    public function getFreshQuotes()
    {
        return app(QuotesManager::class)->driver('api')->quotes();
    }
}
