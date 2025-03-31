<?php

namespace App\InternalAPI\V1\Books\Integrations;

interface ClientInterface
{
    public function setupCredentials(): void;

    public function validateCredentials(): void;

    public function getData(array $query): array;
}
