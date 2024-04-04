<?php

namespace app\models;

use Cassandra\Date;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
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
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

//    Método para a geração do token
    public function generateToken(){
        $header = [
            'typ' => 'JWT',
            'sig' => 'sha-256'
        ];

        $header = base64_encode(json_encode($header));

//        payload com algumas aleatoriedades por segurança
        $payload = [
            'user' => $this->username,
            'date' => date('Y-m-d-m-Y-H-i-s'),
            'rdom' => random_int(1,999)
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', $header . '.' . $payload, 'secret');

        $token = $header . '.' . $payload . '.' . $signature;

        $this->accessToken = $token;
    }
}
