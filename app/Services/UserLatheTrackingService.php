<?php


namespace App\Services;


use App\Models\UserLatheTracking;
use App\Repositories\UserLatheTrackingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\This;

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
     * @throws \Exception
     */
    public function store($input): UserLatheTracking
    {
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation Error.', $validator->errors());
        }

        if ($this->userLatheTrackingRepository->getTrackingWithNullFinish($input)) {
            throw new \Exception('This lathe is busy');
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
     * @throws \Exception
     */
    public function update($input): mixed
    {
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'lathe_id' => 'required'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Validation Error.', $validator->errors());
        }

        $tracking = $this->userLatheTrackingRepository->getTrackingWithNullFinish($input);

        if(!$tracking) {
            throw new \Exception('This user do not work at this lathe now');
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
     */
    public function getLatheHistory($id): mixed
    {
        return $this->userLatheTrackingRepository->getLatheHistory($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserCurrentInfo($id): mixed
    {
        return $this->userLatheTrackingRepository->getUserCurrentInfo($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getLatheCurrentInfo($id): mixed
    {
        return $this->userLatheTrackingRepository->getLatheCurrentInfo($id);
    }
}
