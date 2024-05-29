<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "neighborhood".
 *
 * @property int $neighborhoodId
 * @property string|null $name
 * @property int|null $cityid
 *
 * @property City $city
 * @property Realty[] $realties
 */
class Neighborhood extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'neighborhood';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['neighborhoodId'], 'required'],
            [['neighborhoodId', 'cityid'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['neighborhoodId'], 'unique'],
            [['cityid'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['cityid' => 'cityId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'neighborhoodId' => 'Neighborhood ID',
            'name' => 'Name',
            'cityid' => 'Cityid',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['cityId' => 'cityid']);
    }

    /**
     * Gets query for [[Realties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealties()
    {
        return $this->hasMany(Realty::class, ['neighborhoodId' => 'neighborhoodId']);
    }
}
