<?php

namespace App\Services;

use App\Models\User;

abstract class BaseService
{
    protected $repo;

    /**
     * Set repository
     *
     * @return mixed
     */
    abstract public function setRepo();

    public function __construct()
    {
        $this->setRepo();
    }

    /**
     * Create New Model based on Repo
     *
     * @param  array $params
     * @return Model
     */
    public function create(array $params)
    {
        return $this->repo->create($params);
    }

    /**
     * Get Auth User
     *
     * @param  array $params
     * @return Model
     */
    public function getAuthUser(): User|null
    {
        return auth()->user();
    }
}
