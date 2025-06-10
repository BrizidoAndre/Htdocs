<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prioridades".
 *
 * @property int $id
 * @property string $prioridade
 *
 * @property Tarefas[] $tarefas
 */
class Prioridades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prioridades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prioridade'], 'required'],
            [['prioridade'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prioridade' => 'Prioridade',
        ];
    }

    /**
     * Gets query for [[Tarefas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefas::class, ['id_prioridade' => 'id']);
    }
}
