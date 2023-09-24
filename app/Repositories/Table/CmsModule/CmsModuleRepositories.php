<?php

namespace App\Repositories\Table\CmsModule;

use App\Models\Table\CmsModuleTable;
use App\Repositories\BaseInterface;
use App\Repositories\BaseRepositories;
use App\Repositories\Interfaces\CmsModule\CmsModuleInterface;

class CmsModuleRepositories extends BaseRepositories implements BaseInterface, CmsModuleInterface
{

    public function __construct(CmsModuleTable $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->model->newQuery()
            ->select('*')
            ->get();
    }

    public function getPaginated($search = null, $perPage = 15)
    {
        // TODO: Implement getPaginated() method.
        return $this->model->newQuery()
            ->select('*')
            ->paginate($perPage);
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    public function findBy($column, $value)
    {
        // TODO: Implement findBy() method.
        return $this->model->where($column, $value)->first();
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

}
