<?php

namespace app\models;

use yii\base\Model;

class User extends Model
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    public function fields()
    {
        return ['id'];
    }

    public static function find()
    {
        return self::$users;
    }

    public static function findOne($id)
    {
        return self::$users[$id];
    }

}