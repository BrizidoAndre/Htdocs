<?php

namespace app\controllers;

use app\models\Prato;
use app\models\Restaurante;
use http\Exception\BadMessageException;
use http\Url;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use function PHPUnit\Framework\isNull;

/**
 * RestauranteController implements the CRUD actions for Restaurante model.
 */
class RestauranteController extends Controller
{
    public function actionIndex()
    {
        return Restaurante::find()->all();
    }

    public function actionView($id)
    {
        return Restaurante::findOne($id);
    }

    public function actionCreate()
    {
        $model = new Restaurante();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(201);
            return [
                'message' => 'O restaurante ' . $model->nome_fantasia . ' foi cadastrado com sucesso'
            ];
        } else {
            throw new BadRequestHttpException('Invalid request body');
        }
    }

    public function actionDelete($id)
    {
        $model = Restaurante::findOne($id);

        if($model->delete())
        {
            \Yii::$app->getResponse()->setStatusCode(204);
            return [
                'message' => 'Restaurante foi deletado :('
            ];
        } else{
            throw new BadRequestHttpException("Failed to delete. See if ID is correct");
        }
    }


    public function actionUpdate($id)
    {
        $model = Restaurante::findOne($id);

        if(isNull($model))
        {
            return BadRequestHttpException('Restaurante não encontrado ou inválido');
        }

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save())
        {
            $response = \Yii::$app->getResponse()->setStatusCode(201);

            return [
                'message' => 'O restaurante foi atualizado!'
            ];
        } else{
            throw new BadRequestHttpException('Atualização inválida');
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,

                'formats' => [

                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }


}
