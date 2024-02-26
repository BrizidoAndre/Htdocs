<?php

namespace app\controllers;

use app\models\Prato;
use app\models\PratoSearch;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PratoController implements the CRUD actions for Prato model.
 */
class PratoController extends Controller
{

    public function actionIndex()
    {
        return Prato::find()->orderBy('nome_prato')->all();
    }
}
