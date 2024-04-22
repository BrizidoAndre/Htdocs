<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prato".
 *
 * @property int $id
 * @property string $nome_prato
 * @property int $quantidade_gramas
 * @property int $id_restaurante
 *
 * @property Restaurante $restaurante
 */
class Prato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome_prato', 'quantidade_gramas', 'id_restaurante'], 'required'],
            [['quantidade_gramas', 'id_restaurante'], 'integer'],
            [['nome_prato'], 'string', 'max' => 150],
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::class, 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome_prato' => 'Nome Prato',
            'quantidade_gramas' => 'Quantidade Gramas',
            'id_restaurante' => 'Id Restaurante',
        ];
    }


    public function fields()
    {
        return ['id',"nome_prato", 'quantidade_gramas', 'id_restaurante'];
    }

    public function extraFields()
    {
        return ['restaurante'];
    }

    /**
     * Gets query for [[Restaurante]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurante()
    {
        return $this->hasOne(Restaurante::class, ['id' => 'id_restaurante']);
    }
}
