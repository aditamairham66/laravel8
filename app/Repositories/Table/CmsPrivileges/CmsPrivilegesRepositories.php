<?php

namespace App\Repositories\Table\CmsPrivileges;

use App\Models\Table\CmsPrivilegesTable;
use App\Repositories\BaseInterface;
use App\Repositories\BaseRepositories;
use App\Repositories\Interfaces\CmsPrivileges\CmsPrivilegesInterface;

class CmsPrivilegesRepositories extends BaseRepositories implements BaseInterface, CmsPrivilegesInterface
{

    public function __construct(CmsPrivilegesTable $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->model->newQuery()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function getPaginated($search = null, $perPage = 15)
    {
        // TODO: Implement getPaginated() method.
        return $this->model->newQuery()
            ->select('*')
            ->when($search, function ($q, $search) {
                return $q->where('name', 'LIKE', "%$search%");
            })
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
