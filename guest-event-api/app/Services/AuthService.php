<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthService
{
    //

    public function __construct(private UserRepository $repository) {
    }

    /**
     * store a new user in the database
     *
     * @param array $data
     * @return User
     */
    public function register(array $data) {

        return $this->repository->store([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * authenticate user
     *
     * @param array $data
     * @return User|null
     */
    public function login(array $data) {
        $user = $this->repository->findByEmail($data['email']);
        
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }
        
        return null;
    }
}