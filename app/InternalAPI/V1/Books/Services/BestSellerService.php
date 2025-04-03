<?php

namespace App\InternalAPI\V1\Books\Services;

use App\InternalAPI\V1\Books\Exceptions\NYTApiException;
use App\InternalAPI\V1\Books\Integrations\NYTClient;
use Illuminate\Support\Facades\Log;

class BestSellerService
{
    public function __construct(private readonly NYTClient $client)
    {
    }

    public function getData(array $query): array
    {
        try {
            return $this->client->getData($query);
        } catch (NYTApiException $e) {
            Log::error('NYT API issue', ['error' => $e->getMessage()]);

            return [];
        }
    }
}
