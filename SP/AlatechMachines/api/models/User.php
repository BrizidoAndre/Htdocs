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
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public const all = 'all';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::all] = ['username', 'password', 'accessToken'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
//            creating a scenarion
            [['username', 'password', 'accessToken'], 'required', 'on' => self::all],
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


    public function createToken(){

        $header = [
            'alg' => 'SHA256',
            'typ' => 'JWT'
        ];

        $header = base64_encode(json_encode($header));

        $payload = [
            'username' => $this->username,
            'pwd' => $this->password,
            'time' => date('d-m-Y-H-i-s')
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256', $header . '.' . $payload,'M');

        $this->accessToken = $header . '.' . $payload . '.' . $signature;
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
}
