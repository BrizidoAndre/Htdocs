<?php

namespace app\models\PostUserModel;

use app\models\User;

class PostUserModel extends User
{

    public function fields()
    {
        return [
            'id',
            'username',
            'access_token',
        ];
    }
}