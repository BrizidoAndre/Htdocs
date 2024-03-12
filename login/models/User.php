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
 * @property string|null $accessToken
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
            [['username', 'password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['password', 'accessToken'], 'string', 'max' => 512],
            [['username'], 'unique'],
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


    public function GenerateAccess(){

        $header = [
            'alg' => 'sha-256',
            'typ' => 'JWT token bearer'
        ];

        $header = base64_encode(json_encode($header));

        $payload = [
            'username' => $this->username,
            'id' => $this->id,
            'time' => date('Y-m-d H:i:s')
        ];
        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', $header . '.' . $payload,'secret');

        $token = $header . '.' . $payload . '.' . $signature;

        $this->accessToken = $token;

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
        //todo: Implement validateAuthKey() method.
    }
}
