<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "realty".
 *
 * @property int $realtyid
 * @property string|null $address
 * @property int|null $num_rooms
 * @property bool|null $offer_type
 * @property int|null $rooms_qt
 * @property int|null $toilet_qt
 * @property int|null $parkingspace_qt
 * @property float|null $value
 * @property string|null $comment
 * @property int|null $neighborhoodId
 * @property int|null $categoryid
 *
 * @property Amenity[] $amenities
 * @property Amenityrealty[] $amenityrealties
 * @property Category $category
 * @property Image[] $images
 * @property Neighborhood $neighborhood
 */
class Realty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'realty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['realtyid'], 'required'],
            [['realtyid', 'num_rooms', 'rooms_qt', 'toilet_qt', 'parkingspace_qt', 'neighborhoodId', 'categoryid'], 'integer'],
            [['offer_type'], 'boolean'],
            [['value'], 'number'],
            [['comment'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['realtyid'], 'unique'],
            [['categoryid'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['categoryid' => 'categoryid']],
            [['neighborhoodId'], 'exist', 'skipOnError' => true, 'targetClass' => Neighborhood::class, 'targetAttribute' => ['neighborhoodId' => 'neighborhoodId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'realtyid' => 'Realtyid',
            'address' => 'Endereço',
            'num_rooms' => 'Qtd Quartos',
            'offer_type' => 'Offer Type',
            'rooms_qt' => 'Rooms Qt',
            'toilet_qt' => 'Toilet Qt',
            'parkingspace_qt' => 'Parkingspace Qt',
            'value' => 'Value',
            'comment' => 'Comment',
            'neighborhoodId' => 'Neighborhood ID',
            'categoryid' => 'Categoryid',
        ];
    }

    /**
     * Gets query for [[Amenities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmenities()
    {
        return $this->hasMany(Amenity::class, ['amenityId' => 'amenityId'])->viaTable('amenityrealty', ['realtyid' => 'realtyid']);
    }

    /**
     * Gets query for [[Amenityrealties]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmenityrealties()
    {
        return $this->hasMany(Amenityrealty::class, ['realtyid' => 'realtyid']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['categoryid' => 'categoryid']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['realtyid' => 'realtyid']);
    }

    /**
     * Gets query for [[Neighborhood]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::class, ['neighborhoodId' => 'neighborhoodId']);
    }
}
