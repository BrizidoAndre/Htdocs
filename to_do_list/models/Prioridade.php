<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridade".
 *
 * @property int $IdPrioridade
 * @property string $Titulo
 *
 * @property Tarefa[] $tarefas
 */
class Prioridade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prioridade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Titulo'], 'required'],
            [['Titulo'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdPrioridade' => 'Id Prioridade',
            'Titulo' => 'Titulo',
        ];
    }

    /**
     * Gets query for [[Tarefas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefa::class, ['IdPrioridade' => 'IdPrioridade']);
    }
}
