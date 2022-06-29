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
    public function all()
    {
        return $this->repo->all();
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
     * Create New Model based on Repo
     *
     * @param  array $params
     * @return Model
     */
    public function insert(array $params)
    {
        return $this->repo->insert($params);
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
