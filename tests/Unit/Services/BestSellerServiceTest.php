<?php

namespace Tests\Unit\Services;

use App\InternalAPI\V1\Books\Integrations\NYTClient;
use App\InternalAPI\V1\Books\Services\BestSellerService;
use Illuminate\Foundation\Testing\TestCase;

class BestSellerServiceTest extends TestCase
{
    public function test_service_returns_data_from_client()
    {
        $mockedResponse = [
            ['title' => 'Mocked Book'],
        ];

        $client = $this->createMock(NYTClient::class);
        $client->expects($this->once())
            ->method('getData')
            ->with(['author' => 'Test Author'])
            ->willReturn($mockedResponse);

        $service = new BestSellerService($client);
        $result = $service->getData(['author' => 'Test Author']);

        $this->assertSame($mockedResponse, $result);
    }
}
