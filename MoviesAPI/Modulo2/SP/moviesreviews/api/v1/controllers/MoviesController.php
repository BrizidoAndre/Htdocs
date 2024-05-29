<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Genre;
use app\models\Movie;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class MoviesController extends JsonController
{

    public function actionIndex(
        $pageSize = 4,
        $sortDir = 'desc',
        $sortBy = 'releaseDate',
        $genreId = null,
        $artistId = null
    )
    {

        if ($genreId) {
            if(!Genre::findOne(['id' => $genreId ])){
                throw new BadRequestHttpException('Invalid movie genre id');
            }
            $query = Movie::find()->where(['genreId' => $genreId]);
        } else {
            $query = Movie::find();
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);
    }



    public function actionView($id){

        $movie = Movie::findOne(['id' => $id]);
        if(!$movie){
            throw  new NotFoundHttpException('invalid movie id');
        }

        return $movie;

    }

}