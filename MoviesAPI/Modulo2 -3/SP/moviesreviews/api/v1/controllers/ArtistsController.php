<?php

namespace app\controllers;

use app\models\Artist;
use app\models\ArtistSingle;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class ArtistsController extends Controller
{

    public function actionIndex(
        $page = 1,
        $pageSize = 10,
        $sortDir = 'asc',
        $sortBy = 'name'
    )
    {
        $query = Artist::find();

        $query->addSelect(['artist.*', 'count(credit.id) as moviesCount']);
        $query->joinWith('credits')
            ->groupBy('artist.id')
            ->orderBy("$sortBy $sortDir");


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1,
            ]
        ]);
    }

    public function actionSingle($id)
    {
        $artist = ArtistSingle::findOne(['id' => $id]);

        if ($artist) {
            return $artist;
        }

        \Yii::$app->response->statusCode = 404;
        return [
            'message' => 'Invalid artist id'
        ];
    }

}