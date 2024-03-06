<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "skills".
 *
 * @property int $id
 * @property int $level_id
 * @property int $employee_id
 * @property int $competence_id
 *
 * @property Competences $competence
 * @property Employees $employee
 * @property Levels $level
 */
class Skills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_id', 'employee_id', 'competence_id'], 'required'],
            [['level_id', 'employee_id', 'competence_id'], 'integer'],
            [['competence_id'], 'exist', 'skipOnError' => true, 'targetClass' => Competences::class, 'targetAttribute' => ['competence_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::class, 'targetAttribute' => ['employee_id' => 'id']],
            [['level_id'], 'exist', 'skipOnError' => true, 'targetClass' => Levels::class, 'targetAttribute' => ['level_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_id' => 'Level ID',
            'employee_id' => 'Employee ID',
            'competence_id' => 'Competence ID',
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
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::class, ['id' => 'employee_id']);
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
}
