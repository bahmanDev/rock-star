<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Builder|Model $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    abstract protected function model(): Builder;
    abstract public function all();
    abstract public function paginate($limit = 15);
    abstract public function getBy($col, $value, $limit = 15);
    abstract public function create(array $data);
    abstract public function find($id);
    abstract public function update(Model &$model, array $data);
    abstract public function delete(Model $model);
}
