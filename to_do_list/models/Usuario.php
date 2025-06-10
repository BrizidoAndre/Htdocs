<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $IdUsuario
 * @property string $Nome
 * @property string $Email
 *
 * @property Tarefa[] $tarefas
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Nome', 'Email'], 'required'],
            [['Email'],'email'],
            [['Nome', 'Email'], 'string', 'max' => 100],
            [['Email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdUsuario' => 'Id Usuario',
            'Nome' => 'Nome',
            'Email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Tarefas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefa::class, ['IdUsuario' => 'IdUsuario']);
    }
}
