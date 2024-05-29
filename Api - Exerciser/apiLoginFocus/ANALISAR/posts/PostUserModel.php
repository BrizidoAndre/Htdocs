<?php

namespace app\models\posts;



use app\models\User;

class PostUserModel extends User
{
    public function fields()
    {
        return [
            'id',
            'username'
        ];
    }
}