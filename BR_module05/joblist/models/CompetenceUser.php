<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competence_user".
 *
 * @property int $id
 * @property int $competence_id
 * @property int $level_id
 * @property int $user_id
 * @property int $job_id
 *
 * @property Competences $competence
 * @property UserJob $job
 * @property Levels $level
 * @property UserJob $user
 */
class CompetenceUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competence_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competence_id', 'level_id', 'user_id', 'job_id'], 'required'],
            [['competence_id', 'level_id', 'user_id', 'job_id'], 'integer'],
            [['competence_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competences::class, 'targetAttribute' => ['competence_id' => 'id']],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserJob::class, 'targetAttribute' => ['job_id' => 'job_id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Levels::class, 'targetAttribute' => ['level_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserJob::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competence_id' => 'Competence ID',
            'level_id' => 'Level ID',
            'user_id' => 'User ID',
            'job_id' => 'Job ID',
        ];
    }

    /**
     * Gets query for [[Competence]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetence()
    {
        return $this->hasOne(Competences::class, ['id' => 'competence_id']);
    }

    /**
     * Gets query for [[Job]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(UserJob::class, ['job_id' => 'job_id']);
    }

    /**
     * Gets query for [[Level]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Levels::class, ['id' => 'level_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserJob::class, ['user_id' => 'user_id']);
    }
}
