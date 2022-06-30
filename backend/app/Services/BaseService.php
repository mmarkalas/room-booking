<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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
     * Get Model based on Repo
     *
     * @param  array $params
     * @return Model
     */
    public function get($id)
    {
        return $this->repo->get($id);
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
     * Update Model
     *
     * @param Model $model
     * @return void
     */
    public function update(Model $model, array $params)
    {
        return $this->repo->update($model, $params);
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

    /**
     * Delete Model
     *
     * @param Model $model
     * @return void
     */
    public function delete(Model $model)
    {
        return $this->repo->delete($model);
    }
}
