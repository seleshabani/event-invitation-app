<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * The User model.
     *
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user ?? new User();
    }

    /**
     * Retrieve a specified user from database by id.
     *
     * @param $id
     * @return User
     */
    public function getById($id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Retrieve all user from database.
     *
     * @return Collection|static[]
     */
    public function getAll()
    {
        return $this->user->all();
    }

    /**
     * Get a list of user by pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginate($n = 15)
    {
        return $this->user->paginate($n);
    }

    /**
     * Check if an instance exists according to a given value.
     *
     * @return bool
     */
    public function exists($field, $value, $condition = '=')
    {
        return $this->user->where($field, $condition, $value)->exists();
    }

    /**
     * Retrieve a user from database by a field according to a given value.
     *
     * @return User
     */
    public function get($field, $value, $condition = '=')
    {
        return $this->user->where($field, $condition, $value)->firstOrFail();
    }

    /**
     * Retrieve a listing of user from database according to constraints by pagination.
     *
     * @param array $constraints
     * @param int $n
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListByPagination(array $constraints, $n = 30)
    {
        return $this->user->where($constraints)->paginate($n);
    }

    /**
     * Retrieve a listing of user from database according to constraints.
     *
     * @param array $constraints
     * @return Collection|static[]
     */
    public function getList(array $constraints)
    {
        return $this->user->where($constraints)->get();
    }

    /**
     * Store a new user in the database.
     *
     * @param array $inputs
     * @return User
     */
    public function store(array $inputs)
    {
        return $this->user->create($inputs);
    }

    /**
     * Update a user
     *
     * @return User
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
     * Remove a user from database.
     *
     * @return void
     */
    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    /**
     * Find user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    //
}