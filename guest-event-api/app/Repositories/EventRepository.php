<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository
{
    /**
     * The Event model.
     *
     * @var Event
     */
    protected $event;

    /**
     * EventRepository constructor.
     *
     * @param Event|null $event
     */
    public function __construct(Event $event = null)
    {
        $this->event = $event ?? new Event();
    }

    /**
     * Retrieve a specified event from database by id.
     *
     * @param $id
     * @return Event
     */
    public function getById($id)
    {
        return $this->event->findOrFail($id);
    }

    /**
     * Retrieve all event from database.
     *
     * @return Collection|static[]
     */
    public function getAll()
    {
        return $this->event->all();
    }

    /**
     * Get a list of event by pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginate($n = 15)
    {
        return $this->event->paginate($n);
    }

    /**
     * Check if an instance exists according to a given value.
     *
     * @return bool
     */
    public function exists($field, $value, $condition = '=')
    {
        return $this->event->where($field, $condition, $value)->exists();
    }

    /**
     * Retrieve a event from database by a field according to a given value.
     *
     * @return Event
     */
    public function get($field, $value, $condition = '=')
    {
        return $this->event->where($field, $condition, $value)->firstOrFail();
    }

    /**
     * Retrieve a listing of event from database according to constraints by pagination.
     *
     * @param array $constraints
     * @param int $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListByPagination(array $constraints, $n = 30)
    {
        return $this->event->where($constraints)->paginate($n);
    }

    /**
     * Retrieve a listing of event from database according to constraints.
     *
     * @param array $constraints
     * @return Collection|static[]
     */
    public function getList(array $constraints)
    {
        return $this->event->where($constraints)->get();
    }

    /**
     * Store a new event in the database.
     *
     * @param array $inputs
     * @return Event
     */
    public function store(array $inputs)
    {
        return $this->event->create($inputs);
    }

    /**
     * Update a event
     *
     * @return Event
     */
    public function update(array $inputs, $id)
    {
        $instance = $this->getById($id);
        foreach($inputs as $property => $value)
            $instance->$property = $value;
        $instance->save();
        return $this->getById($id);
    }

    /**
     * Remove a event from database.
     *
     * @return void
     */
    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    //
}