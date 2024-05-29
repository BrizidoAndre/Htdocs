<?php

namespace app\models\bases;

use app\models\Movie;
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
                return $hours . 'h' . $minutes . 'm';
            },
            'releaseDate',
            'score' => function () {
                $reviews = $this->reviews;

                $stars = 0;
                foreach ($reviews as $review) {
                    $stars += $review->stars;
                }

                $media = $stars / count($reviews);

                return round($media);
            },
            'reviewsCount' => function () {
                return count($this->reviews);
            },
            'posterUrl' => function () {
                return BaseUrl::base(true) . '/media/'. $this->posterUrl;
            },
            'trailerUrl' => function(){
                return BaseUrl::base(true) . '/media/' . $this->trailerUrl;
            },
            'credits'
        ];
    }
}