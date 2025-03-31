<?php

namespace App\InternalAPI\V1\Books\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellerFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        // TODO Add user or role validation.
        return true;
    }

    /**
     * Rules:
     * - author: optional string.
     * - isbn: optional string matching either a 10- or 13-digit ISBN, or multiple ISBNs separated by semicolons.
     * - offset: optional integer that must be a multiple of 20.
     * - title: optional string.
     */
    public function rules(): array
    {
        return [
            'author' => 'sometimes|string|max:255',
            'isbn' => 'sometimes|array',
            'isbn.*' => [
                'string',
                // Regex explanation:
                //  ^                     Start of string.
                //  (\d{10}|\d{13})       One ISBN: either 10 or 13 digits.
                //  (;(\\d{10}|\\d{13}))* Optionally, additional ISBNs preceded by semicolons.
                //  $                     End of string.
                'regex:/^(\d{10}|\d{13})(;(\d{10}|\d{13}))*$/'
            ],
            'offset' => [
                'sometimes',
                'integer',
                function ($attribute, $value, $fail): void {
                    if ($value % 20 !== 0) {
                        $fail("The {$attribute} must be a multiple of 20.");
                    }
                }
            ],
            'title' => 'sometimes|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'isbn.regex' => 'The ISBN must be a 10 or 13 digit number. For multiple ISBNs, separate them with semicolons.',
        ];
    }
}
