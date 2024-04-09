<?php

namespace app\models\UserLogin;

use app\models\User;

class UserLogin extends User
{
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

}