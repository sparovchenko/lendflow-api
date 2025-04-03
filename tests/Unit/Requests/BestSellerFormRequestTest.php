<?php

namespace Tests\Unit\Requests;

use App\InternalAPI\V1\Books\Requests\BestSellerFormRequest;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Validator;

class BestSellerFormRequestTest extends TestCase
{
    private function validate(array $data): array
    {
        $request = new BestSellerFormRequest();
        $rules = $request->rules();

        return Validator::make($data, $rules)->errors()->toArray();
    }

    public function test_valid_data_passes()
    {
        $errors = $this->validate([
            'author' => 'John Smith',
            'title' => 'Sample Book',
            'isbn' => ['1234567890', '1234567890123'],
            'offset' => 40,
        ]);

        $this->assertEmpty($errors);
    }

    public function test_invalid_offset_fails()
    {
        $errors = $this->validate([
            'offset' => 15,
        ]);

        $this->assertArrayHasKey('offset', $errors);
        $this->assertStringContainsString('multiple of 20', $errors['offset'][0]);
    }

    public function test_invalid_isbn_structure_fails()
    {
        $errors = $this->validate([
            'isbn' => ['invalid_isbn'],
        ]);

        $this->assertArrayHasKey('isbn.0', $errors);
    }

    public function test_missing_fields_passes_validation()
    {
        $errors = $this->validate([]);
        $this->assertEmpty($errors);
    }
}
