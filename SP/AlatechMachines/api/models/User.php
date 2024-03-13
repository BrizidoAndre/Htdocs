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
 * @property-read void $authKey
 * @property string $accessToken
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
            [['username', 'password'], 'required'],
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

    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
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

    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

//    MÉTODO PARA A CRIAÇÃO DE UM TOKEN DURANTE O LOGIN
    public function generateToken(){
        $header = [
            'typ' => 'JWT',
            'alg' => 'sha-256'
        ];
        $header = base64_encode(json_encode($header));



        $payload = [
            'user' => $this->username,
            'time' => date('Y-m-d H:m:s:v:u')
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256',$header . '.' . $payload,'secret');

        $this->accessToken = $header . '.' . $payload . '.' . $signature;

    }
}
