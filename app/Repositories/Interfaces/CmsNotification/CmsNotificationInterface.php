<?php

namespace App\Repositories\Interfaces\CmsNotification;

interface CmsNotificationInterface
{
    public function getNotificationByUsersPaginated($usersId, $search = null, $perPage = 15);

}
