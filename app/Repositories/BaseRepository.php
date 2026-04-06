<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model
            ->orderByDesc('id')
            ->get();
    }
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        return $record->update($data);
    }
    public function delete(int $id)
    {
        $record = $this->find($id);
            return $record->delete();
    }
}
