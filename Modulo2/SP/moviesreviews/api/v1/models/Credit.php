<?php

namespace app\models;

use Yii;
use yii\helpers\BaseUrl;
use yii\web\UrlRule;

/**
 * This is the model class for table "credit".
 *
 * @property int $id
 * @property int $movieId
 * @property int $artistId
 * @property int $roleId
 *
 * @property Artist $artist
 * @property Movie $movie
 * @property Role $role
 */
class Credit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'credit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['movieId', 'artistId', 'roleId'], 'required'],
            [['movieId', 'artistId', 'roleId'], 'integer'],
            [['artistId'], 'exist', 'skipOnError' => true, 'targetClass' => Artist::class, 'targetAttribute' => ['artistId' => 'id']],
            [['movieId'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::class, 'targetAttribute' => ['movieId' => 'id']],
            [['roleId'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['roleId' => 'id']],
        ];
    }

    public function fields()
    {
        return [
            'artistId',
            'artist' => function (){
            return $this->artist->name;
            },
            'role' => function(){
            return $this->role->title;
            },
            'photoUrl' => function(){
            return BaseUrl::base(true) . '/media/' . $this->artist->photoUrl;
            },
            'singlePageUrl' => function(){
            return BaseUrl::base(true) . '/artists/' .  $this->artistId;
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
            'movieId' => 'Movie ID',
            'artistId' => 'Artist ID',
            'roleId' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Artist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArtist()
    {
        return $this->hasOne(Artist::class, ['id' => 'artistId']);
    }

    /**
     * Gets query for [[Movie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movie::class, ['id' => 'movieId']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'roleId']);
    }
}
