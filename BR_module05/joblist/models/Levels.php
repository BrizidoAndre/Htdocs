<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "levels".
 *
 * @property int $id
 * @property string $level
 * @property float $factor
 *
 * @property CompetenceUser[] $competenceUsers
 */
class Levels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'levels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'factor'], 'required'],
            [['factor'], 'number'],
            [['level'], 'string', 'max' => 8000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'factor' => 'Factor',
        ];
    }

    /**
     * Gets query for [[CompetenceUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompetenceUsers()
    {
        return $this->hasMany(CompetenceUser::class, ['level_id' => 'id']);
    }
}
