<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "state".
 *
 * @property int $stateId
 * @property string|null $name
 * @property string|null $acronym
 *
 * @property City[] $cities
 */
class State extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stateId', 'name', 'acronym'], 'required'],
            [['acronym'], 'unique'],
            [['stateId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['acronym'], 'string', 'max' => 2, 'min' => 2],
            [['acronym'], 'match', 'pattern' => '/^[a-z]\w*$/i', 'message' => 'Acrônimo deve ser letras do alfabeto'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'stateId' => 'State ID',
            'name' => 'Nome',
            'acronym' => 'Sigla do estado',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['stateid' => 'stateId']);
    }
}
