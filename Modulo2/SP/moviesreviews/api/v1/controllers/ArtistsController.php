<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Artist;
use app\models\bases\ArtistSingle;
use yii\data\ActiveDataProvider;
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
        $query = Artist::find();

        $sortDirection = $sortDir === 'desc' ? SORT_DESC : SORT_ASC;

        return new ActiveDataProvider([
            'pagination' => [
                'pageSize' => $pageSize,
                'page' => $page - 1
            ],
            'query' => $query,
            'sort' => [
                'defaultOrder' =>[
                    $sortBy => $sortDirection
                ]
            ]
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