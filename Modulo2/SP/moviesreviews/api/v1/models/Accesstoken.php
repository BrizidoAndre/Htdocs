<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accesstoken".
 *
 * @property int $id
 * @property int $userId
 * @property string $tokenString
 * @property string $creationDate
 *
 * @property User $user
 */
class Accesstoken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'accesstoken';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'tokenString'], 'required'],
            [['userId'], 'integer'],
            [['tokenString'], 'string'],
            [['creationDate'], 'safe'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'tokenString' => 'Token String',
            'creationDate' => 'Creation Date',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }


    public function createToken(){
        $header = [
            'typ' => 'JWT',
            'cod' => 'sha256'
        ];


        $header = base64_encode(json_encode($header));

        $payload = [
            'user' => $this->user->username,
            'date' => date('d-m-Y-H-i-s')
        ];

        $payload = base64_encode(json_encode($payload));

        $signature = hash_hmac('sha256',$header . '.' . $payload, 'banana' );

        $this->tokenString = $header . '.' . $payload . '.' . $signature;
    }


    public function createAccessToken($id){
        $this->userId = $id;

        date_default_timezone_set('America/Sao_Paulo');
        $this->creationDate = date('Y-m-d H:i:s');
        $this->createToken();

    }
}
