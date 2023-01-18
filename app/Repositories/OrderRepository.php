<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository
{
    protected function model(): Builder
    {
        return Order::query();
    }

    public function all()
    {
        $this->model->orderBy('id')->get();
    }

    public function paginate($limit = 15)
    {
        return $this->model->orderBy('id', 'desc')->with('products')->paginate($limit);
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
        return $this->model->with('user', 'orderInformation')->find($id);
    }

    public function findUserOrder($orderId, $userId)
    {
        return $this->model->where('id', $orderId)->where('user_id', $userId)->with('user', 'orderInformation')->first();
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
