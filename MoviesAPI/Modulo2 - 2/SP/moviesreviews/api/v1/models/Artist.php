<?php

namespace app\models;

use Yii;
use yii\helpers\BaseUrl;

/**
 * This is the model class for table "artist".
 *
 * @property int $id
 * @property string $name
 * @property string|null $birthday
 * @property string|null $photoUrl
 * @property string|null $biography
 *
 * @property Credit[] $credits
 */
class Artist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'photoUrl', 'biography'], 'string'],
            [['birthday'], 'string', 'max' => 10],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'photoUrl' => function () {
                return BaseUrl::base(true) . '/media/' . $this->photoUrl;
            },
            'singlePage' => function () {
                return BaseUrl::base(true) . '/artists/' . $this->id;
            },
            'moviesCount' => function(){
            return count($this->credits);
            }
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
            'birthday' => 'Birthday',
            'photoUrl' => 'Photo Url',
            'biography' => 'Biography',

        ];
    }

    /**
     * Gets query for [[Credits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredits()
    {
        return $this->hasMany(Credit::class, ['artistId' => 'id']);
    }
}
