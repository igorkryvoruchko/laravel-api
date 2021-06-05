<?php

namespace App\Http\Controllers\Api;

use App\Models\Lathe;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Lathe as LatheResource;

class LatheController extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $lathes = Lathe::all();

        return $this->sendResponse(LatheResource::collection($lathes), 'retrieved successfully.');
    }
}
