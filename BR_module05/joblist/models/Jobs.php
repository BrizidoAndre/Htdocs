<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id
 * @property string $job
 *
 * @property Competences[] $competences
 * @property UserJob[] $userJobs
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['job'], 'required'],
            [['job'], 'string', 'max' => 8000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job' => 'Job',
        ];
    }

    /**
     * Gets query for [[Competences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetences()
    {
        return $this->hasMany(Competences::class, ['job_id' => 'id']);
    }

    /**
     * Gets query for [[UserJobs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserJobs()
    {
        return $this->hasMany(UserJob::class, ['job_id' => 'id']);
    }
}
