<?php

namespace app\controllers;

use app\models\Prato;
use app\models\PratoSearch;
use app\models\Restaurante;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\throwException;

/**
 * PratoController implements the CRUD actions for Prato model.
 */
class PratoController extends Controller
{
//    método que busca todos os pratos cadastrados de um restaurante
    public function actionIndex($id){

        $restaurante = Restaurante::find()->where('id' === $id);
        if($restaurante === null)
        {
            throw new NotFoundHttpException('Não existe um restaurante com esse identificador');
        }
        return Prato::find()->where(['id_restaurante' => $id])->all();

    }

//    método para buscar o prato com base no id específico
    public function actionView($id_prato){
        return Prato::find()->where(['id' => $id_prato])->one();
    }

    public function behaviors()
    {

        return [
            'authenticator' => [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBearerAuth::class
                ]
            ]
        ];
    }

}
