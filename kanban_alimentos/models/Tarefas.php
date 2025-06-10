<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarefas".
 *
 * @property int $id
 * @property int $id_user
 * @property string $descricao
 * @property string $setor
 * @property int $id_prioridade
 * @property int|null $id_status
 *
 * @property Prioridades $prioridade
 * @property Status $status
 * @property Users $user
 */
class Tarefas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarefas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'descricao', 'setor', 'id_prioridade'], 'required'],
            [['id_user', 'id_prioridade', 'id_status'], 'integer'],
            [['descricao'], 'string'],
            ['data_cadastro', 'default', 'value' => date('Y-m-d')],
            [['setor'], 'string', 'max' => 255],
            [['id_status'], 'default', 'value' => 1],
            [['id_prioridade'], 'exist', 'skipOnError' => true, 'targetClass' => Prioridades::class, 'targetAttribute' => ['id_prioridade' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['id_status' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Usuário',
            'descricao' => 'Descrição',
            'setor' => 'Setor',
            'id_prioridade' => 'Prioridade',
            'id_status' => 'Id Status',
        ];
    }

    /**
     * Gets query for [[Prioridade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPrioridade()
    {
        return $this->hasOne(Prioridades::class, ['id' => 'id_prioridade']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'id_status']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'id_user']);
    }
}
