<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Genre;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use function PHPUnit\Framework\returnArgument;

class GenresController extends JsonController
{
    public function actionIndex(
        $page = 1,
        $pageSize = 10,
        $sortDir = 'desc',
        $sortBy = 'title'
    ){

        if($sortDir !== 'desc' && $sortDir !== 'asc'){
            throw new BadRequestHttpException('Valor inválido para sortDir');
        }
        if($sortBy !== 'title' && $sortBy !== 'moviesCount'){
            throw new BadRequestHttpException('Valor inválido para sortBy');
        }


        $query = Genre::find()->select(['genre.id', 'genre.title','count(movie.id) as moviesCount'])
            ->joinWith('movies')
            ->groupBy('genre.id')
            ->orderBy($sortBy . ' ' . $sortDir);


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1,
            ]
        ]);

    }
}