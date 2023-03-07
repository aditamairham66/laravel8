<?php

namespace App\Repositories\Table\CmsNotification;

use App\Models\Table\CmsNotificationTable;
use App\Repositories\BaseInterface;
use App\Repositories\BaseRepositories;
use App\Repositories\Interfaces\CmsNotification\CmsNotificationInterface;

class CmsNotificationRepositories extends BaseRepositories implements BaseInterface, CmsNotificationInterface
{

    public function __construct(CmsNotificationTable $model)
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

    public function getNotificationByUsersPaginated($usersId, $search = null, $perPage = 15)
    {
        // TODO: Implement getPaginated() method.
        return $this->model->newQuery()
            ->select('*')
            ->where('cms_users_id', $usersId)
            ->when($search, function ($q, $search) {
                return $q->where('name', 'LIKE', "%$search%");
            })
            ->paginate($perPage);
    }

}
