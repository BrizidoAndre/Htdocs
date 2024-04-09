<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "animais".
 *
 * @property int $id
 * @property string $nome
 * @property int $npata
 * @property int $carnivoro
 * @property string $rugido
 */
class Animais extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'animais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'npata', 'carnivoro', 'rugido'], 'required'],
            [['npata', 'carnivoro'], 'integer'],
            [['nome', 'rugido'], 'string', 'max' => 255],
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
            'npata' => 'Npata',
            'carnivoro' => 'Carnivoro',
            'rugido' => 'Rugido',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'Nome alternativo' => 'nome',
            'status' => function(Animais $animal) {
                return ($animal->carnivoro == "1" ? 'Comedor de carne': 'Comedor de gramas');
            },
            'Nº de pés' => function(Animais $animal) {
                return ($animal->npata === 4 ? 'Quadrúpede' : 'Bípede ou alienígena');
            },
            'Som' => 'rugido'
        ];
    }
}
