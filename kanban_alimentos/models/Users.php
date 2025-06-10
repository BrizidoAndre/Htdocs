<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 *
 * @property Tarefas[] $tarefas
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email'], 'required'],
            [['nome', 'email'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Tarefas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarefas()
    {
        return $this->hasMany(Tarefas::class, ['id_user' => 'id']);
    }
}
