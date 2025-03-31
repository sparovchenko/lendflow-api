<?php

use App\InternalAPI\V1\Books\Integrations\NYTClient;
use App\InternalAPI\V1\Books\Services\BestSellerService;

beforeEach(function () {
    config([
        'services.nyt.key' => 'test_key',
        'services.nyt.url' => 'https://api.nytimes.com/test'
    ]);
    Http::preventStrayRequests();
});

afterEach(function () {
    Mockery::close();
});

it('returns valid best sellers data via API endpoint', function () {
    Http::fake([
        'https://api.nytimes.com/test*' => Http::response([
            'results' => [
                'title' => 'Test Book',
                'description' => 'Test description',
                'author' => 'John Doe',
                'publisher' => 'Test Publisher',
            ],
        ], 200),
    ]);

    $response = $this->getJson('/api/v1/books/best_sellers?author=John');

    $response->assertOk();
    $response->assertJsonStructure([
        '*' => [
            'title',
            'description',
            'author',
            'publisher',
        ],
    ]);
});

it('returns an error when the NYT API request fails', function () {
    Http::fake([
        'https://api.nytimes.com/test*' => Http::response([], 500),
    ]);

    $response = $this->getJson('/api/v1/books/best_sellers?author=John');

    $response->assertStatus(200);
    $response->assertSee('error');
});

it('validates query parameters and fails on invalid input', function () {
    $response = $this->getJson('/api/v1/books/best_sellers?isbn=test');
    $response->assertStatus(422);
});

it('handles missing API credentials gracefully', function () {
    config(['services.nyt.key' => '']);

    $nytClient = new NYTClient();
    $result = $nytClient->getData(['author' => 'John']);

    expect($result)->toHaveKey('error');
    expect($result['error'])->toContain('Please specify NYT API key');
});

it('returns data via the service layer using a mocked NYTClient', function () {
    $fakeQuery = ['author' => 'Jane'];
    $fakeResponse = [
        [
            'title' => 'Service Test Book',
            'description' => 'Service test description',
            'author' => 'Jane Doe',
            'publisher' => 'Service Test Publisher',
        ],
    ];

    $nytClientMock = Mockery::mock(NYTClient::class);

    $nytClientMock->shouldReceive('getData')
        ->once()
        ->with($fakeQuery)
        ->andReturn($fakeResponse);

    $service = new BestSellerService($nytClientMock);

    $data = $service->getData($fakeQuery);

    expect($data)->toBeArray();
    expect($data[0])->toHaveKeys(['title', 'description', 'author', 'publisher']);
});
