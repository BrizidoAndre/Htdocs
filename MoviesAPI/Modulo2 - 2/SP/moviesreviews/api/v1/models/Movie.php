<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property int $genreId
 * @property string $title
 * @property string|null $synopsis
 * @property int|null $durationMinutes
 * @property string|null $releaseDate
 * @property string|null $posterUrl
 * @property string|null $trailerUrl
 *
 * @property Credit[] $credits
 * @property Genre $genre
 * @property Review[] $reviews
 */
class Movie extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['genreId', 'title'], 'required'],
            [['genreId', 'durationMinutes'], 'integer'],
            [['title', 'synopsis', 'posterUrl', 'trailerUrl'], 'string'],
            [['releaseDate'], 'string', 'max' => 10],
            [['title'], 'unique'],
            [['genreId'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genreId' => 'id']],
        ];
    }


    public function fields()
    {
        return [
            'id',
            'genreId',
            'title',
            'synopsis',
            'duration' => function () {

                $this->durationMinutes;


                $hours = intdiv($this->durationMinutes, 60);
                $minutes = $this->durationMinutes % 60;
                return $hours . 'h ' . $minutes . 'm';
            },
            'releaseDate',
            'score' => function () {
                $reviews = Review::findAll(['movieId' => $this->id]);

                $totalScore = 0;

                foreach ($reviews as $review) {
                    $totalScore += $review->stars;
                }

                return $totalScore / count($reviews);
            },
            'reviewsCount' => function(){
                $reviews = Review::findAll(['movieId' => $this->id]);
                return count($reviews);
            },
            'posterUrl',
            'singlePageUrl' => function () {

                return Yii::getAlias("@web") . '/movies/' . $this->id;
            },

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genreId' => 'Genre ID',
            'title' => 'Title',
            'synopsis' => 'Synopsis',
            'durationMinutes' => 'Duration Minutes',
            'releaseDate' => 'Release Date',
            'posterUrl' => 'Poster Url',
            'trailerUrl' => 'Trailer Url',
        ];
    }

    /**
     * Gets query for [[Credits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCredits()
    {
        return $this->hasMany(Credit::class, ['movieId' => 'id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genreId']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['movieId' => 'id']);
    }
}
