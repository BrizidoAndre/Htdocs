<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Artist;
use app\models\bases\ArtistSingle;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ArtistsController extends JsonController
{

    public function actionIndex(
        $page = 1,
        $pageSize = 10,
        $sortDir = 'asc',
        $sortBy = 'name'
    )
    {

        if($sortDir !== 'asc' && $sortDir !== 'desc'){
            throw new BadRequestHttpException('Valor inválido para sortDir');
        }

        if($sortBy !== 'name' && $sortBy !== 'moviesCount'){
            throw new BadRequestHttpException('Valor inválido para sortBy');
        }

        $query = Artist::find();

        $sort = new Sort([
            'attributes' => [
                'moviesCount'
            ],
        ]);


        return new ActiveDataProvider([
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1
            ],
            'query' => $query,
            'sort' => $sort
        ]);
    }

    public function actionGet($id)
    {

        $artist = ArtistSingle::findOne(['id' => $id]);

        if (!$artist) {
            throw new NotFoundHttpException('Invalid artist id');
        }

        return $artist;
    }

}