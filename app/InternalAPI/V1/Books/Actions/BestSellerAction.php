<?php

namespace App\InternalAPI\V1\Books\Actions;

use App\InternalAPI\V1\Books\Requests\BestSellerFormRequest;
use App\InternalAPI\V1\Books\Resources\BestSellerResource;
use App\InternalAPI\V1\Books\Services\BestSellerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BestSellerAction
{
    public function __invoke(BestSellerFormRequest $request, BestSellerService $service): AnonymousResourceCollection
    {
        return BestSellerResource::collection($service->getData($request->toArray()));
    }
}
