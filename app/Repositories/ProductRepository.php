<?php

namespace App\Repositories;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends  Repository
{

    protected function model(): Builder
    {
        return Product::query();
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

    public function saveOptions(Model $model, $data)
    {
        return $model->options()->save(new Option($data));
    }

    public function find($id)
    {
        return $this->model->with('options')->find($id);
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
