<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "amenityrealty".
 *
 * @property int $amenityId
 * @property int $realtyid
 * @property int|null $numAmenity
 *
 * @property Amenity $amenity
 * @property Realty $realty
 */
class Amenityrealty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'amenityrealty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amenityId', 'realtyid'], 'required'],
            [['amenityId', 'realtyid', 'numAmenity'], 'integer'],
            [['amenityId', 'realtyid'], 'unique', 'targetAttribute' => ['amenityId', 'realtyid']],
            [['amenityId'], 'exist', 'skipOnError' => true, 'targetClass' => Amenity::class, 'targetAttribute' => ['amenityId' => 'amenityId']],
            [['realtyid'], 'exist', 'skipOnError' => true, 'targetClass' => Realty::class, 'targetAttribute' => ['realtyid' => 'realtyid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'amenityId' => 'Amenity ID',
            'realtyid' => 'Realtyid',
            'numAmenity' => 'Num Amenity',
        ];
    }

    /**
     * Gets query for [[Amenity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmenity()
    {
        return $this->hasOne(Amenity::class, ['amenityId' => 'amenityId']);
    }

    /**
     * Gets query for [[Realty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealty()
    {
        return $this->hasOne(Realty::class, ['realtyid' => 'realtyid']);
    }
}
