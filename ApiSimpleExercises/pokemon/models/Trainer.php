<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trainer".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property int|null $medals
 *
 * @property Pokemons[] $pokemons
 */
class Trainer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trainer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['medals'], 'integer', "message" => 'O valor precisa ser um valor inteiro sua besta'],
            [['name', 'email'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'medals' => 'Medals',
        ];
    }

    /**
     * Gets query for [[Pokemons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPokemons()
    {
        return $this->hasMany(Pokemons::class, ['idTrainer' => 'id']);
    }
}
