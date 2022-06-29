<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    /**
     * Set model of repository
     *
     * @return mixed
     */
    abstract public function setModel();

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Save new model
     *
     * @param  array $params
     * @return Model
     */
    public function create($params): Model
    {
        return $this->model::create($params);
    }

    /**
     * Get model by id
     *
     * @param  int $id
     * @return Model
     */
    public function get($id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get model by id
     *
     * @param  int $id
     * @return Model
     */
    public function firstOrNew($id): Model
    {
        return $this->model->firstOrNew($id);
    }

    /**
     * Get All Models
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Update model
     *
     * @param  Model $model
     * @param  array $data
     * @return Model
     */
    public function update($model, $data): Model
    {
        foreach ($data as $key => $value) {
            $model->{$key} = $value;
        }

        $model->save();

        return $model;
    }

    /**
     * Delete model record
     *
     * @param  Model $model
     * @return bool
     */
    public function delete($model)
    {
        $delete = $model->delete();

        return ($delete) ? true : false;
    }

    public function withTrashed()
    {
        $this->withTrashed = true;

        return $this;
    }
}
