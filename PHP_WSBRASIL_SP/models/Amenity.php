<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "amenity".
 *
 * @property int $amenityId
 * @property string|null $name
 *
 * @property Amenityrealty[] $amenityrealties
 * @property Realty[] $realties
 */
class Amenity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'amenity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amenityId'], 'required'],
            [['amenityId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['amenityId'], 'unique'],
            [['name'], 'default','value' => 'socorro']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'amenityId' => 'Amenity ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Amenityrealties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmenityrealties()
    {
        return $this->hasMany(Amenityrealty::class, ['amenityId' => 'amenityId']);
    }

    /**
     * Gets query for [[Realties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRealties()
    {
        return $this->hasMany(Realty::class, ['realtyid' => 'realtyid'])->viaTable('amenityrealty', ['amenityId' => 'amenityId']);
    }
}
