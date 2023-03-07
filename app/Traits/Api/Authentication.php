<?php

namespace App\Traits\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait Authentication
{
    use Token;

    private static $entity = [
        "id",
        "name",
        "email",
        "type",
    ];

    function decode($token)
    {
        return JWT::decode($token, new Key($this->key(), 'HS256'));
    }

    function encode($data)
    {
        return JWT::encode($data, $this->key(), 'HS256');
    }

    function create($value)
    {
        $jwtPayload = [
            'usersData' => $value,
            'exp' => $this->timeExp()
        ];
        return $this->encode($jwtPayload);
    }

    function update($token, $data = [])
    {
        JWT::$leeway = $this->timeExp();
        $tokenOld = (array) $this->decode($token);
        $tokenOld['exp'] = $this->timeExp();
        if (!empty($data)) {
            $tokenOld['usersData'] = $data;
        }

        return JWT::encode($tokenOld, $this->key(), 'HS256');
    }

    function auth()
    {
        $auth = request()->header('Authorization');
        $token = $this->getToken($auth);
        // get users data
        $data =  $this->decode($token);
        $data = $data->usersData;

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

}
