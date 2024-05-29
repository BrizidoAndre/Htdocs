<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "professor".
 *
 * @property int $id
 * @property string $materia
 * @property int $idLogin
 *
 */
class Professor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['materia', 'idLogin'], 'required'],
            [['idLogin'], 'integer'],
            [['materia'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'materia' => 'Materia',
            'idLogin' => 'Professor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class,['id' => 'idLogin']);
    }


}
