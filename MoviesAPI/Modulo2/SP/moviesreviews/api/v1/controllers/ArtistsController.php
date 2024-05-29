<?php

namespace app\controllers;

use app\bases\JsonController;
use app\models\Artist;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ArtistsController extends JsonController
{

    public function actionIndex($pageSize = 10, $sortDir = 'asc', $sortBy = 'name'){

        $query = Artist::find();

        return new ActiveDataProvider([
            'pagination' => [
                'pageSize' => $pageSize
            ],
            'query' => $query
        ]);
    }

    public function actionView($id){

        $artist = Artist::findOne(['id' => $id]);

        if(!$artist){
            throw new NotFoundHttpException('Invalid artist id');
        }

        return $artist;
    }

}