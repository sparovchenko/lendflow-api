<?php

namespace App\InternalAPI\V1\Books\Actions;

use App\InternalAPI\V1\Books\Requests\BestSellerFormRequest;
use App\InternalAPI\V1\Books\Resources\BookResource;
use App\InternalAPI\V1\Books\Services\BestSellerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetBestSellersAction
{
    public function __invoke(
        BestSellerFormRequest $request,
        BestSellerService $service,
    ): AnonymousResourceCollection {
        return BookResource::collection($service->getData($request->toArray()));
    }
}
