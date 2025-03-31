<?php

namespace App\InternalAPI\V1\Books\Services;

use App\InternalAPI\V1\Books\Integrations\NYTClient;

class BestSellerService
{
    public function __construct(private readonly NYTClient $client)
    {

    }

    public function getData(array $query): array
    {
        return $this->client->getData($query);
    }
}
