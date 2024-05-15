<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Artist;
use app\models\Credit;
use app\models\Genre;
use app\models\Movie;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class MoviesController extends JsonController
{

    public function actionIndex(
        $page = 1,
        $pageSize = 4,
        $sortDir = 'desc',
        $sortBy = 'releaseDate',
        $genreId = null,
        $artistId = null
    )
    {

        return \Yii::$app->user->identity;
        $query = Movie::find();

        if($sortDir === 'desc'){
            $sortDirection = SORT_DESC;
        }
        if($sortDir === 'asc'){
            $sortDirection = SORT_ASC;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1
            ],
            'sort' => [
                'defaultOrder' => [
                    $sortBy => $sortDirection,
                ]
            ],
        ]);
    }


    public function actionView($id)
    {

        $movie = Movie::findOne(['id' => $id]);
        if (!$movie) {
            throw  new NotFoundHttpException('invalid movie id');
        }

        return $movie;

    }

}