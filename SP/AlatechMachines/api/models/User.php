<?php

namespace app\models;

use app\base\AuthBase;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Yii;
use yii\db\ActiveRecordInterface;
use yii\filters\auth\CompositeAuth;
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

    public function validatePassword($password)
    {
        if (Yii::$app->security->validatePassword($password, $this->password)) {
            return true;
        }
        return false;
    }

    public function generateAccessToken()
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $header = base64_encode(json_encode($header));

        $payload = [
            'sub' => $this->username,
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', $header . '.' . $payload, 'secretkey');

        $this->accessToken = $header . '.' . $payload . '.' . $signature;

    }



}
