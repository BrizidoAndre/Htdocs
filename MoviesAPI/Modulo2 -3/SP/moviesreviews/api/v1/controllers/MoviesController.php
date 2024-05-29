<?php

namespace app\controllers;

use app\models\Artist;
use app\models\Genre;
use app\models\Movie;
use app\models\MovieSingle;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;

class MoviesController extends Controller
{
    public function actionIndex(
        $page = 1,
        $pageSize = 4,
        $sortDir = 'desc',
        $sortBy = 'releaseDate',
        $genreId = null,
        $artistId = null
    ){

        $query = Movie::find();


        if($genreId && !Genre::findOne(['id' => $genreId])){
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid movie genre id'
            ];
        }
        if($artistId && !Artist::findOne(['id' => $artistId])){
            \Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Invalid artist id'
            ];
        }


        if($genreId){
            $query->andWhere(['genreId'=> $genreId]);
        }

        $query->addSelect(['movie.*', 'ROUND(AVG(review.stars)) as score', 'COUNT(review.id) as reviewsCount']);
        $query->joinWith('reviews');
        $query->groupBy('movie.id');
        $query->orderBy("$sortBy $sortDir");

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page -1
            ],
        ]);

    }


    public function actionSingle($id){

        $movie = MovieSingle::findOne(['id' => $id]);

        if($movie){
            return $movie;
        }

        \Yii::$app->response->statusCode = 404;
        return [
            'message' => 'Invalid  movie id'
        ];
    }

}