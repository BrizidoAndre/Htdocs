<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pokemons".
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property int $idTrainer
 *
 * @property Eggs[] $eggs
 * @property Trainer $idTrainer0
 */
class Pokemons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pokemons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'idTrainer'], 'required'],
            [['idTrainer'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
            [['idTrainer'], 'exist', 'skipOnError' => true, 'targetClass' => Trainer::class, 'targetAttribute' => ['idTrainer' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'type' => 'Tipo',
            'idTrainer' => 'Treinador',
        ];
    }

    /**
     * Gets query for [[Eggs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEggs()
    {
        return $this->hasMany(Eggs::class, ['idPokemon' => 'id']);
    }

    /**
     * Gets query for [[IdTrainer0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainer()
    {
        return $this->hasOne(Trainer::class, ['id' => 'idTrainer']);
    }
}
