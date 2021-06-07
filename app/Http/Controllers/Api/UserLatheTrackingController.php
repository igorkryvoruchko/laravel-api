<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserLatheTracking as UserLatheTrackingResource;
use App\Models\User;
use App\Models\UserLatheTracking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserLatheTrackingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
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

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (UserLatheTracking::where('lathe_id', $input['lathe_id'])->where('finish', null)->first()) {
            return $this->sendError('This lathe is busy');
        }

        $input['start'] = Carbon::now();

        $tracker = UserLatheTracking::create($input);

        return $this->sendResponse(new UserLatheTrackingResource($tracker), 'User start working successfully.');
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

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tracker = UserLatheTracking::where('user_id', $input['user_id'])
            ->where('lathe_id', $input['lathe_id'])
        ->where('finish', null)->first();

        if(!$tracker) {
            return $this->sendError('This user do not work at this lathe');
        }

        $tracker->finish = Carbon::now();
        $tracker->save();

        return $this->sendResponse(new UserLatheTrackingResource($tracker), 'User finish working successfully.');
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getUserHistory($id): JsonResponse
    {
        $userHistory = UserLatheTracking::where('user_id', $id)->paginate(1);

        if (!count($userHistory)) {
            return $this->sendError('User history not found', [],404);
        }

        return $this->sendResponse(UserLatheTrackingResource::collection($userHistory), 'User history retrieved successfully.');
    }
}
