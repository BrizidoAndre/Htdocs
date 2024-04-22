<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alunos".
 *
 * @property int $id
 * @property string $name
 * @property int $ano
 * @property int $idProfessor
 * @property int $idUsuario
 *
 * @property Professores $idProfessor0
 * @property Usuarios $idUsuario0
 */
class Alunos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alunos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'ano', 'idProfessor', 'idUsuario'], 'required'],
            [['ano', 'idProfessor', 'idUsuario'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['idUsuario' => 'id']],
            [['idProfessor'], 'exist', 'skipOnError' => true, 'targetClass' => Professores::class, 'targetAttribute' => ['idProfessor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'ano' => 'Ano',
            'idProfessor' => 'Id Professor',
            'idUsuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[IdProfessor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfessor0()
    {
        return $this->hasOne(Professores::class, ['id' => 'idProfessor']);
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'idUsuario']);
    }
}
