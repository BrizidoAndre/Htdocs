<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "competences".
 *
 * @property int $id
 * @property string $competence
 * @property int $height
 * @property int $job_id
 *
 * @property CompetenceUser[] $competenceUsers
 * @property Jobs $job
 */
class Competences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'competences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competence', 'height', 'job_id'], 'required'],
            [['height', 'job_id'], 'integer'],
            [['competence'], 'string', 'max' => 8000],
            [['job_id'], 'exist', 'skipOnError' => true, 'targetClass' => Jobs::class, 'targetAttribute' => ['job_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'competence' => 'Competence',
            'height' => 'Height',
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
        return $this->hasMany(CompetenceUser::class, ['competence_id' => 'id']);
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
}
