<?php

namespace App\Repositories\Table\CmsUsers;

use App\Models\Table\CmsUsersTable;
use App\Repositories\BaseInterface;
use App\Repositories\BaseRepositories;
use App\Repositories\Interfaces\CmsUsers\CmsUsersInterface;

class CmsUsersRepositories extends BaseRepositories implements BaseInterface, CmsUsersInterface
{
    public function __construct(CmsUsersTable $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getPaginated($search = null, $perPage = 15)
    {
        // TODO: Implement getPaginated() method.
        return $this->model->newQuery()
            ->select('*')
            ->with([
                'privileges' => function ($query) use ($search) {
                    $query->when($search, function ($q, $search) {
                        return $q->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            ])
            ->when($search, function ($q, $search) {
                return $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
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
