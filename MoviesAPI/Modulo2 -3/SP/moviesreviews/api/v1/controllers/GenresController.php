<?php

namespace app\controllers;

use app\models\Genre;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class GenresController extends Controller
{

    public function actionIndex(
        $page = 1,
        $pageSize = 10,
        $sortDir = 'desc',
        $sortBy = 'title'
    ){
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';
        $sortBy = ($sortBy !== "title" && $sortBy !== "moviesCount")  ? 'title' : $sortBy;

        $query = Genre::find();

        $query->addSelect(['genre.*', 'COUNT(movie.id) AS moviesCount']);

        $query->joinWith('movies');
        $query->groupBy('genre.id');

        $query->orderBy("$sortBy $sortDir");

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'page' => $page -1,
                'pageSize' => $pageSize
            ]
        ]);
    }
}