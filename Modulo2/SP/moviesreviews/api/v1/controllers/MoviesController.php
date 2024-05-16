<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\bases\MovieSingle;
use app\models\Movie;
use yii\data\ActiveDataProvider;
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

        if ($sortDir === 'desc') {
            $sortDirection = SORT_DESC;
        }
        if ($sortDir === 'asc') {
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


    public function actionGet($id)
    {
        $movie = MovieSingle::findOne(['id' => $id]);
        if (!$movie) {
            throw  new NotFoundHttpException('Invalid movie id');
        }

        return $movie;

    }

}