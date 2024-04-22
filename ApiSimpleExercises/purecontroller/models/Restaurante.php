<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurante".
 *
 * @property int $id
 * @property string $nome_fantasia
 * @property string $endereco
 *
 * @property Prato[] $pratos
 */
class Restaurante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome_fantasia', 'endereco'], 'required'],
            [['nome_fantasia'], 'string', 'max' => 200],
            [['endereco'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return ['id', 'nome_fantasia', 'endereco'];
    }

    public function extraFields()
    {
        return ['pratos'];
    }


    /**
     * Gets query for [[Pratos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPratos()
    {
        return $this->hasMany(Prato::class, ['id_restaurante' => 'id']);
    }
}
