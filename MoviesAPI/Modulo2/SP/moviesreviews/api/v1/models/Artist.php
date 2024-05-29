<?php

namespace app\models;

use Yii;

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

        $fields =  parent::fields();


        $fields['singlePage'] = function (){
                return Yii::getAlias("@web") . '/artists/' . $this->id;
        };


        $fields['moviesCount'] = function (){
            $credits = Credit::findAll(['artistId' => $this->id]);

            return count($credits);
        };

        $fields['movies'] = function(){
            $credits = Credit::findAll(['artistId' => $this->id]);

            $movies = [];

            foreach ($credits as $credit) {
                $newMovie = Movie::findOne(['id' => $credit->movieId]);

                if($newMovie){
                    unset($newMovie->synopsis);
                    $movies[] = $newMovie;
                }
            }
            return $movies;
        };

        return $fields;
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
