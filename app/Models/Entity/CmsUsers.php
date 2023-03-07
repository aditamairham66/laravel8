<?php

namespace App\Models\Entity;

use App\Models\BaseModel;

class CmsUsers extends BaseModel
{
    protected $table = "cms_users";

    public function privileges()
    {
        return $this->belongsTo(CmsPrivileges::class, 'cms_privileges_id', 'id');
    }
}
