<?php

namespace App\Traits\Admin;

use Illuminate\Support\Facades\Session;

trait Authentication
{
    private static $entity = [
        "id",
        "name",
        "email",
        "photo",
        "privileges_id",
        "privileges_name",
    ];

    static function create($value)
    {
        return Session::put('admin_login', (object) $value);
    }

    static function auth()
    {
        $data = Session::get('admin_login');

        return (object) collect(self::$entity)
            ->mapWithKeys(function ($row, $i) use ($data){
                if (in_array($row, ['id', 'privileges_id'])) {
                    $val = (!empty($data->$row)?$data->$row:0);
                } else {
                    $val = (!empty($data->$row)?$data->$row:"");
                }
                return [
                    $row => $val
                ];
            })->toArray();
    }

    static function destroy()
    {
        return Session::forget('admin_login');
    }
}
