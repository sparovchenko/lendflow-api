<?php

namespace App\InternalAPI\V1\Books\Integrations;

use App\InternalAPI\V1\Books\Exceptions\NYTApiException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NYTClient implements ClientInterface
{
    protected string $apiKey = '';

    protected string $baseUrl = '';

    protected array $params = [];

    public function setupCredentials(): void
    {
        $this->apiKey = config('services.nyt.key');
        $this->baseUrl = config('services.nyt.url');
    }

    public function validateCredentials(): void
    {
        throw_if(
            ! $this->apiKey,
            new NYTApiException(__('Please specify NYT API key')),
        );
        throw_if(
            ! $this->baseUrl,
            new NYTApiException(__('Please specify NYT base URL')),
        );
    }

    public function getData(array $query): array
    {
        $this->setupCredentials();
        $this->validateCredentials();
        $this->handleQueryParams($query);

        $response = $this->makeHttpRequest();

        throw_if(
            empty($response),
            new NYTApiException(__('Failed to fetch NYT data')),
        );

        return $response;
    }

    public function makeHttpRequest(): array
    {
        $cacheKey = 'nyt_api_'.md5(json_encode($this->params));

        return Cache::remember($cacheKey, 3600, function () {
            $response = Http::get($this->baseUrl, $this->params);

            return $response->failed() ? [] : $response['results'];
        });
    }

    protected function handleQueryParams(array $query): array
    {
        $this->params['api-key'] = $this->apiKey;

        if (! empty($query['author'])) {
            $this->params['author'] = $query['author'];
        }

        if (! empty($query['title'])) {
            $this->params['title'] = $query['title'];
        }

        if (! empty($query['isbn']) && is_array($query['isbn'])) {
            $this->params['isbn'] = implode(',', $query['isbn']);
        }

        if (isset($query['offset'])) {
            $this->params['offset'] = $query['offset'];
        }

        return $this->params;
    }
}
