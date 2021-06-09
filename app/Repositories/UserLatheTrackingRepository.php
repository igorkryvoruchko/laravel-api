<?php


namespace App\Repositories;


use App\Models\UserLatheTracking;

class UserLatheTrackingRepository
{

    /**
     * UserLatheTrackingRepository constructor.
     * @param UserLatheTracking $userLatheTracking
     */
    public function __construct(
        private UserLatheTracking $userLatheTracking
    )
    {
    }

    /**
     * @param $input
     * @return mixed
     */
    public function getTrackingWithNullFinish($input): mixed
    {
        return $this->userLatheTracking->where('user_id', $input['user_id'])
            ->where('lathe_id', $input['lathe_id'])
            ->where('finish', null)->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserHistory($id): mixed
    {
        return $this->userLatheTracking->where('user_id', $id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getLatheHistory($id): mixed
    {
        return $this->userLatheTracking->where('lathe_id', $id)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserCurrentInfo($id): mixed
    {
        return $this->userLatheTracking->where('user_id', $id)
            ->whereNull('finish')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getLatheCurrentInfo($id): mixed
    {
        return $this->userLatheTracking->where('lathe_id', $id)
            ->whereNull('finish')->first();
    }
}
