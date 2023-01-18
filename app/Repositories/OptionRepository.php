<?php

namespace App\Repositories;

use App\Models\Option;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OptionRepository extends  Repository
{

    protected function model(): Builder
    {
        return Option::query();
    }

    public function all()
    {
        $this->model->orderBy('id')->get();
    }

    public function paginate($limit = 15)
    {
        return $this->model->orderBy('id', 'desc')->paginate($limit);
    }

    public function getBy($col, $value, $limit = 15)
    {
        return $this->model->where($col, $value)->limit($limit)->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update(Model &$model, array $data)
    {
        return $model->update($data);
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }
}
