<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserLatheTracking as UserLatheTrackingResource;
use App\Models\Lathe;
use App\Models\User;
use App\Services\UserLatheTrackingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserLatheTrackingController extends BaseController
{
    /**
     * UserLatheTrackingController constructor.
     * @param UserLatheTrackingService $userLatheTrackingService
     */
    public function __construct(
        private UserLatheTrackingService $userLatheTrackingService
    )
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        try {
            $tracking = $this->userLatheTrackingService->store($input);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse(new UserLatheTrackingResource($tracking), 'User start working successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $input = $request->all();

        try {
            $tracking = $this->userLatheTrackingService->update($input);
        } catch(\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

        return $this->sendResponse(new UserLatheTrackingResource($tracking), 'User finish working successfully.');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getUserHistory($id): JsonResponse
    {
        if (!User::find($id)) {
            return $this->sendError('User not found', [],404);
        }

        $userHistory = $this->userLatheTrackingService->getUserHistory($id);

        return $this->sendResponse(UserLatheTrackingResource::collection($userHistory), 'User history retrieved successfully.');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getLatheHistory($id): JsonResponse
    {
        if (!Lathe::find($id)) {
            return $this->sendError('Lathe not found', [],404);
        }

        $latheHistory = $this->userLatheTrackingService->getLatheHistory($id);

        return $this->sendResponse(UserLatheTrackingResource::collection($latheHistory), 'Lathe history retrieved successfully.');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getUserCurrentInfo($id): JsonResponse
    {
        if (!User::find($id)) {
            return $this->sendError('User not found', [],404);
        }

        $currentLathes = $this->userLatheTrackingService->getUserCurrentInfo($id);

        return $this->sendResponse(UserLatheTrackingResource::collection($currentLathes), 'Current lathes for user retrieved successfully.');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getLatheCurrentInfo($id): JsonResponse
    {
        if (!Lathe::find($id)) {
            return $this->sendError('Lathe not found', [],404);
        }

        $currentUser = $this->userLatheTrackingService->getLatheCurrentInfo($id);

        if (!$currentUser) {
            return $this->sendError('Lathe is free');
        }

        return $this->sendResponse(new UserLatheTrackingResource($currentUser), 'Current user for lathe retrieved successfully.');
    }
}
