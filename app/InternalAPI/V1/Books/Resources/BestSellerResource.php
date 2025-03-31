<?php

namespace App\InternalAPI\V1\Books\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BestSellerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'title' => data_get($this, 'title'),
            'description' => data_get($this, 'description'),
            'author' => data_get($this, 'author'),
            'publisher' => data_get($this, 'publisher'),
        ];
    }
}
