<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eggs".
 *
 * @property int $id
 * @property string|null $color
 * @property int|null $timeHatch
 * @property int $idPokemon
 *
 * @property Pokemons $idPokemon0
 */
class Eggs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eggs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['timeHatch', 'idPokemon'], 'integer'],
            [['idPokemon'], 'required'],
            [['color'], 'string', 'max' => 255],
            [['idPokemon'], 'exist', 'skipOnError' => true, 'targetClass' => Pokemons::class, 'targetAttribute' => ['idPokemon' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Cor',
            'timeHatch' => 'Dias para chocar',
            'idPokemon' => 'Id Pokemon',
        ];
    }

    /**
     * Gets query for [[IdPokemon0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemon()
    {
        return $this->hasOne(Pokemons::class, ['id' => 'idPokemon']);
    }
}
