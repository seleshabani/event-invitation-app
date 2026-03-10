<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;

class EventService
{
    //

    public function __construct(private EventRepository $repository) {
    }


    /**
     * Endpoint to get all events for the authenticated user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllForAuth() {
        
        return $this->repository->getListByPagination([
            'user_id' => Auth::user()->id
        ]);
    }

    /**
     * Endpoint to create a new event
     *
     * @param array $data
     * @return Event
     */
    public function store(array $data) {
        $data['user_id'] = Auth::user()->id;
        return $this->repository->store($data);
    }

    /**
     * Get event by ID for authenticated user
     *
     * @param int $id
     * @return Event
     */
    public function getById($id) {
        return $this->repository->getById($id);
    }
}