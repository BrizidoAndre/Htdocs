<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aluno".
 *
 * @property int $id
 * @property string $nome
 * @property int $idProfessor
 * @property int $idUsuario
 */
class Aluno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aluno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'idProfessor', 'idUsuario'], 'required'],
            [['idProfessor', 'idUsuario'], 'integer'],
            [['nome'], 'string', 'max' => 100],
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
            'idProfessor' => 'Id Professor',
            'idUsuario' => 'Id Usuario',
        ];
    }
}
