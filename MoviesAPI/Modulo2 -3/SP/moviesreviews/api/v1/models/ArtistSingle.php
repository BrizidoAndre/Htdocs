<?php

namespace app\models;

use yii\helpers\BaseUrl;

class ArtistSingle extends Artist
{

    public function fields()
    {
        return [
            'name',
            'birthday',
            'biography',
            'photoUrl' => function () {
                return BaseUrl::base(true) . '/media/' . $this->photoUrl;
            },
            'movies' => function (){
                $credits = Credit::findAll(['artistId' => $this->id]);

                $movies = [];
                foreach ($credits as $credit) {
                    $movies[] = $credit->movie;
                }
                return $movies;
            }
        ];
    }

}