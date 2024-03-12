<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $accessToken
 * @property string $authKey
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
            [['username', 'password', 'accessToken'], 'required'],
            [['username'], 'string', 'max' => 64],
            [['password', 'accessToken'], 'string', 'max' => 512],
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
            'accessToken' => 'Access Token',
        ];
    }


    public function GenerateToken(){

        $header = [
            'alg' => "HS256",
            'typ' => 'JWT'
        ];

        $header = base64_encode(json_encode($header));


        $payload = [
            'name' => $this->username,
            'id' => $this->id
        ];

        $payload = base64_encode(json_encode($payload));

        $data = $header . '.' . $payload;

        $signature = hash_hmac('sha256', $data, 'secret');

        $this->accessToken = $header . '.' . $payload . '.' . $signature;

        return $this->accessToken;
    }

    public static function findIdentity($id)
    {
        return self::$id;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        if(Yii::$app->security->validatePassword($password, $this->password)){
            return true;
        }
        return false;
    }
}
