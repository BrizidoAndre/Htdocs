<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_job".
 *
 * @property int $id
 * @property int $user_id
 * @property int $job_id
 *
 * @property CompetenceUser[] $competenceUsers
 * @property CompetenceUser[] $competenceUsers0
 * @property Jobs $job
 * @property Users $user
 */
class UserJob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'job_id'], 'required'],
            [['user_id', 'job_id'], 'integer'],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jobs::class, 'targetAttribute' => ['job_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'job_id' => 'Job ID',
        ];
    }

    /**
     * Gets query for [[CompetenceUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetenceUsers()
    {
        return $this->hasMany(CompetenceUser::class, ['job_id' => 'job_id']);
    }

    /**
     * Gets query for [[CompetenceUsers0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetenceUsers0()
    {
        return $this->hasMany(CompetenceUser::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Jobs::class, ['id' => 'job_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
