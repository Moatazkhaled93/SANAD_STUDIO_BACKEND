<?php

namespace App\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find user by email
     *
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email);

    /**
     * Get users with specific role
     *
     * @param string $role
     * @return mixed
     */
    public function getUsersByRole(string $role);
}
