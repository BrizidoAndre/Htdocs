<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $registration_date
 * @property string|null $last_login_date
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['registration_date', 'last_login_date'], 'safe'],
            [['username'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 255, 'min' => 6, 'message' => 'A senha deve conter mais de 6 dígitos' ],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'registration_date' => 'Registration Date',
            'last_login_date' => 'Last Login Date',
        ];
    }


    public static function findByUsername($username){

        return self::findOne(['username' => $username]);
    }

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['password' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
    }

    public function validateAuthKey($authKey)
    {
        throw new NotSupportedException();
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

}
