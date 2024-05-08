<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $username
 * @property string|null $phone_number
 *
 * @property UserJob[] $userJobs
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username'], 'required'],
            [['email', 'username', 'phone_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'username' => 'Username',
            'phone_number' => 'Phone Number',
        ];
    }

    /**
     * Gets query for [[UserJobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobs()
    {
        return $this->hasMany(UserJob::class, ['user_id' => 'id']);
    }
}
