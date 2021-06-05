<?php

namespace App\Http\Controllers\Api;

use App\Models\UserLatheTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserLatheTracking as UserLatheTrackingResource;

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
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if(UserLatheTracking::where('lathe_id', $input['lathe_id'])->where('finish', null)->first()) {
            return $this->sendError('This lathe is busy');
        }

        $input['start'] = Carbon::now();

        $tracker = UserLatheTracking::create($input);

        return $this->sendResponse(new UserLatheTrackingResource($tracker), 'User start working successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  UserLatheTracking  $userLatheTracking
     * @return JsonResponse
     */
    public function update(Request $request, UserLatheTracking $userLatheTracking): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  UserLatheTracking  $userLatheTracking
     * @return JsonResponse
     */
    public function destroy(UserLatheTracking $userLatheTracking): JsonResponse
    {
        //
    }
}
