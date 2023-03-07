<?php

namespace App\Repositories;

interface BaseInterface
{
    public function getAll();

    public function getPaginated($search = null, $perPage = 15);

    public function getById($id);

    public function findBy($column, $value);

    public function create($data);

    public function update($id, $data);

    public function delete($id);
}
