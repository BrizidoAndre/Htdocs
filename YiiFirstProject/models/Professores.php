<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "professores".
 *
 * @property int $id
 * @property string $name
 * @property string $materia
 * @property int $idUsuario
 *
 * @property Alunos[] $alunos
 * @property Usuarios $idUsuario0
 */
class Professores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'materia', 'idUsuario'], 'required'],
            [['idUsuario'], 'integer'],
            [['name', 'materia'], 'string', 'max' => 100],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['idUsuario' => 'id']],
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
            'materia' => 'Materia',
            'idUsuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[Alunos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlunos()
    {
        return $this->hasMany(Alunos::class, ['idProfessor' => 'id']);
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
