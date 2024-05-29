<?php

namespace app\models\bases;

use app\models\Artist;
use yii\helpers\BaseUrl;

class ArtistSingle extends Artist
{
    public function fields()
    {
        return [
            'name',
            'birthday',
            'biography',
            'photoUrl' => function(){
            return BaseUrl::base(true) . '/media/' . $this->photoUrl;
            },
            'movies' => function(){
            return MovieSingle::findOne(['id' => 1])->title;
            }
        ];

    }
}