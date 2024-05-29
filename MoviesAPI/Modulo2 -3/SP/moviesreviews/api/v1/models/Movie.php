<?php

namespace app\models;

use Yii;
use yii\helpers\BaseUrl;

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

    public $score;
    public $reviewsCount;

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
            'title',
            'duration' => function () {
                $hours = intdiv($this->durationMinutes, 60);
                $minutes = $this->durationMinutes % 60;
                return "$hours h $minutes m";
            },
            'releaseDate',
            'score',
            'reviewsCount',
            'posterUrl' => fn() => BaseUrl::base(true) . '/media/' . $this->posterUrl,
            'singlePageUrl' => fn() => BaseUrl::base(true) . '/movies/' . $this->id,
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
     * Gets query for [[ReviewsController]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['movieId' => 'id']);
    }
}
