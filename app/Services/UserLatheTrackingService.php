<?php

namespace App\Services;

use App\Exceptions\ValidatorException;
use App\Models\Lathe;
use App\Models\User;
use App\Models\UserLatheTracking;
use App\Repositories\UserLatheTrackingRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class UserLatheTrackingService
{
    /**
     * UserLatheTrackingService constructor.
     * @param UserLatheTrackingRepository $userLatheTrackingRepository
     */
    public function __construct(
        private UserLatheTrackingRepository $userLatheTrackingRepository
    )
    {
    }

    /**
     * @param $input
     * @return UserLatheTracking
     * @throws ValidatorException
     */
    public function store($input): UserLatheTracking
    {
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(
                'Validation Error.',
                400,
                null,
                [
                    'errors' => $validator->errors()
                ]
            );
        }

        if ($this->userLatheTrackingRepository->getTrackingWithNullFinish($input)) {
            throw new ValidatorException('This lathe is busy', 400);
        }

        $tracking = new UserLatheTracking();
        $tracking->user_id = $input['user_id'];
        $tracking->lathe_id = $input['lathe_id'];
        $tracking->start = Carbon::now();
        $tracking->save();

        return $tracking;
    }

    /**
     * @param $input
     * @return mixed
     * @throws ValidatorException
     */
    public function update($input): mixed
    {
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(
                'Validation Error.',
                400,
                null,
                [
                    'errors' => $validator->errors()
                ]
            );
        }

        $tracking = $this->userLatheTrackingRepository->getTrackingWithNullFinish($input);

        if(!$tracking) {
            throw new ValidatorException('This user do not work at this lathe now', 400);
        }

        $tracking->finish = Carbon::now();
        $tracking->save();

        return $tracking;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserHistory($id): mixed
    {
        return $this->userLatheTrackingRepository->getUserHistory($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getLatheHistory($id): mixed
    {
        if (!Lathe::find($id)) {
            throw new Exception('Lathe not found',404);
        }

        return $this->userLatheTrackingRepository->getLatheHistory($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getUserCurrentInfo($id): mixed
    {
        if (!User::find($id)) {
            throw new Exception('User not found',404);
        }

        return $this->userLatheTrackingRepository->getUserCurrentInfo($id);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getLatheCurrentInfo($id): mixed
    {
        if (!Lathe::find($id)) {
            throw new Exception('Lathe not found',404);
        }

        $currentUserInfo = $this->userLatheTrackingRepository->getLatheCurrentInfo($id);

        if (!$currentUserInfo) {
            throw new Exception('Lathe is free');
        }

        return $currentUserInfo;
    }
}
