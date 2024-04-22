<?php

namespace app\models;

use app\models\PostUserModel\PostUserModel;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class SignUpForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;

    public $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'password_repeat'], 'required'],
            ['username', 'unique',
                'targetClass' => '\app\models\PostUserModel\PostUserModel',
                'message' => 'this username has already been taken.'
            ],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }


    public function register()
    {
        $this->_user = new PostUserModel();
        if ($this->validate()) {
            $security = Yii::$app->security;
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
