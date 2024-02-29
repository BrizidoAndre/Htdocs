<?php

namespace app\models;

use app\models\posts\PostUserModel;
use yii\base\Model;

class SignUpForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $_user = false;

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            ['username', 'unique',
                'targetClass' => 'app\models\posts\PostUserModel',
                'message' => 'Username has already been taken'
            ],
            ['password', 'compare', 'compareAttribute' => 'password_repeat']
        ];
    }


    public function register()
    {
        $this->_user = new PostUserModel();

        if ($this->validate()) {
            $security = \Yii::$app->security;

            $this->_user = new User();
            $this->_user->username = $this->username;
            $this->_user->password_hash = $security->generatePasswordHash($this->password);

            if ($this->_user->save()) {
                return true;
            }
            return false;
        }
        return false;
    }


}