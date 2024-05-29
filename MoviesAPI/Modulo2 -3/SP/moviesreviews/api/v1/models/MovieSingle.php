<?php

namespace app\models;

use yii\helpers\BaseUrl;

class MovieSingle extends Movie
{
    public function fields()
    {
        return [
            'title',
            'synopsis',
            'duration' => function () {
                $hours = intdiv($this->durationMinutes, 60);
                $minutes = $this->durationMinutes % 60;
                return "$hours h $minutes m";
            },
            'releaseDate',
            'score' => function (){
                $reviews = Review::findAll(['movieId' => $this->id]);

                $allScore = 0;
                foreach ($reviews as $review) {
                    $allScore += $review->stars;
                }

                return intdiv($allScore, count($reviews));
            },
            'reviewsCount' => function (){
                return count(Review::findAll(['movieId' => $this->id]));
            },
            'posterUrl' => function(){
                return BaseUrl::base(true). '/media/' . $this->posterUrl;
            },
            'trailerUrl' => function(){
                return BaseUrl::base(true) . '/media/' . $this->trailerUrl;
            },
            'credits'
        ];
    }
}