<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filhote".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $nascimento
 * @property int|null $pai
 *
 * @property Animais $pai0
 */
class Filhote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filhote';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nascimento'], 'safe'],
            [['pai'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['pai'], 'exist', 'skipOnError' => true, 'targetClass' => Animais::class, 'targetAttribute' => ['pai' => 'id']],
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
            'nascimento' => 'Nascimento',
            'pai' => 'Pai',
        ];
    }

    /**
     * Gets query for [[Pai0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPai0()
    {
        return $this->hasOne(Animais::class, ['id' => 'pai']);
    }
}
