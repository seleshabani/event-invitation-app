<?php

namespace App\Repositories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GuestRepository
{
    /**
     * The Guest model.
     *
     * @var Guest
     */
    protected $guest;

    /**
     * GuestRepository constructor.
     *
     * @param Guest|null $guest
     */
    public function __construct(Guest $guest = null)
    {
        $this->guest = $guest ?? new Guest();
    }

    /**
     * Retrieve a specified guest from database by id.
     *
     * @param $id
     * @return Guest
     */
    public function getById($id)
    {
        return $this->guest->findOrFail($id);
    }

    /**
     * Retrieve all guest from database.
     *
     * @return Collection|static[]
     */
    public function getAll()
    {
        return $this->guest->all();
    }

    /**
     * Get a list of guest by pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginate($n = 15)
    {
        return $this->guest->paginate($n);
    }

    /**
     * Check if an instance exists according to a given value.
     *
     * @return bool
     */
    public function exists($field, $value, $condition = '=')
    {
        return $this->guest->where($field, $condition, $value)->exists();
    }

    /**
     * Retrieve a guest from database by a field according to a given value.
     *
     * @return Guest
     */
    public function get($field, $value, $condition = '=')
    {
        return $this->guest->where($field, $condition, $value)->firstOrFail();
    }

    /**
     * Retrieve a listing of guest from database according to constraints by pagination.
     *
     * @param array $constraints
     * @param int $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListByPagination(array $constraints, $n = 30)
    {
        return $this->guest->where($constraints)->paginate($n);
    }

    /**
     * Retrieve a listing of guest from database according to constraints.
     *
     * @param array $constraints
     * @return Collection|static[]
     */
    public function getList(array $constraints)
    {
        return $this->guest->where($constraints)->get();
    }

    /**
     * Store a new guest in the database.
     *
     * @param array $inputs
     * @return Guest
     */
    public function store(array $inputs)
    {
        return $this->guest->create($inputs);
    }

    /**
     * Update a guest
     *
     * @return Guest
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
     * Remove a guest from database.
     *
     * @return void
     */
    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    //
}