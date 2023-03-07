<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepositories
{
    public $model;

    protected $guard = null;

    protected $debug;

    public function __construct(Model $model)
    {
        // create model instance
        $this->model = $model;
    }
}
