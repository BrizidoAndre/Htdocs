<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $IdStatus
 * @property string $Status
 *
 * @property Tarefa[] $tarefas
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Status'], 'required'],
            [['Status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdStatus' => 'Id Status',
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Tarefas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefa::class, ['IdStatus' => 'IdStatus']);
    }
}
