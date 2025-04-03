<?php

namespace Tests\Unit\Integrations;

use App\InternalAPI\V1\Books\Exceptions\NYTApiException;
use App\InternalAPI\V1\Books\Integrations\NYTClient;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class NYTClientTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Cache::flush();

        Config::set('services.nyt.key', 'fake-key');
        Config::set('services.nyt.url', 'https://fake-nyt-api.test/books');
    }

    public function test_successful_api_response_returns_expected_data()
    {
        Http::fake([
            '*' => Http::response([
                'results' => [
                    [
                        'title' => 'Offline Test Book',
                        'description' => 'Test description',
                        'author' => 'Test Author',
                        'publisher' => 'Test Publisher',
                    ],
                ],
            ], 200),
        ]);

        $client = new NYTClient();
        $data = $client->getData(['author' => 'Offline']);

        $this->assertEquals('Offline Test Book', $data[0]['title']);
    }

    public function test_failed_api_response_throws_custom_exception()
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $client = new NYTClient();

        $this->expectException(NYTApiException::class);
        $this->expectExceptionMessage('Failed to fetch NYT data');

        $client->getData(['author' => 'Broken']);
    }

    public function test_missing_api_key_throws_validation_error()
    {
        Config::set('services.nyt.key', '');

        $client = new NYTClient();

        $this->expectExceptionMessage('Please specify NYT API key');

        $client->getData([]);
    }
}
