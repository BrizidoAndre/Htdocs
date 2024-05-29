<?php

namespace app\controllers;

use app\models\City;
use app\models\Neighborhood;
use app\models\State;
use app\models\StateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StateController implements the CRUD actions for State model.
 */
class StateController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all State models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new StateSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new State();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single State model.
     * @param int $stateId State ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($stateId)
    {
        return $this->render('view', [
            'model' => $this->findModel($stateId),
        ]);
    }

    /**
     * Creates a new State model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new State();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                    $model->stateId = count(State::find()->all()) + 1;
                    $model->acronym = strtoupper($model->acronym);

                if ($model->save()) {
                    return $this->redirect(['state/index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing State model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $stateId State ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($stateId)
    {
        $model = $this->findModel($stateId);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'stateId' => $model->stateId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing State model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $stateId State ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($stateId)
    {
        $cidades = City::findAll(['stateid' => $stateId]);

        foreach ($cidades as $cidade) {
            Neighborhood::deleteAll(['cityid' => $cidade->cityId]);
            $cidade->delete();
        }

        $this->findModel($stateId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the State model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $stateId State ID
     * @return State the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($stateId)
    {
        if (($model = State::findOne(['stateId' => $stateId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
