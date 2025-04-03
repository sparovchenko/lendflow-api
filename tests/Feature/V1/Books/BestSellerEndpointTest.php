<?php

namespace Tests\Feature\V1\Books;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BestSellerEndpointTest extends TestCase
{
    public function test_returns_successful_response_with_expected_structure()
    {
        Http::fake([
            '*' => Http::response([
                'results' => [
                    [
                        'title' => 'Mock Book',
                        'description' => 'Test description',
                        'author' => 'Test Author',
                        'publisher' => 'Test Publisher',
                    ],
                ],
            ], 200),
        ]);

        Config::set('services.nyt.key', 'fake-key');
        Config::set('services.nyt.url', 'https://fake-url.test');

        $response = $this->getJson('/api/v1/books/best_sellers?author=Test+Author');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'title',
                    'description',
                    'author',
                    'publisher',
                ],
            ],
        ]);

        $response->assertJsonFragment([
            'title' => 'Mock Book',
        ]);
    }

    public function test_invalid_offset_returns_validation_error()
    {
        $response = $this->getJson('/api/v1/books/best_sellers?offset=7');

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['offset']);
    }
}
