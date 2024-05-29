<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $cityId
 * @property string|null $name
 * @property int|null $stateid
 *
 * @property Neighborhood[] $neighborhoods
 * @property State $state
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cityId', 'name',], 'required', 'message' => 'Faltando'],
            [['stateid'], 'required', 'message' => 'Estado faltando!'],
            [['cityId', 'stateid'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['cityId'], 'unique'],
            [['stateid'], 'exist', 'skipOnError' => true, 'targetClass' => State::class, 'targetAttribute' => ['stateid' => 'stateId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cityId' => 'City ID',
            'name' => 'Nome',
            'stateid' => 'Estado correspondente',
        ];
    }

    /**
     * Gets query for [[Neighborhoods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::class, ['cityid' => 'cityId']);
    }

    /**
     * Gets query for [[State]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::class, ['stateId' => 'stateid']);
    }
}
