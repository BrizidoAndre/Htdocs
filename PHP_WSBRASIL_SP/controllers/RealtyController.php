<?php

namespace app\controllers;

use app\models\Realty;
use app\models\RealtySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RealtyController implements the CRUD actions for Realty model.
 */
class RealtyController extends Controller
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
     * Lists all Realty models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RealtySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Realty model.
     * @param int $realtyid Realtyid
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($realtyid)
    {
        return $this->render('view', [
            'model' => $this->findModel($realtyid),
        ]);
    }

    /**
     * Creates a new Realty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Realty();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->realtyid = count(Realty::find()->all()) + 1;
                if ($model->save()) {
                    return $this->redirect(['view', 'realtyid' => $model->realtyid]);
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
     * Updates an existing Realty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $realtyid Realtyid
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($realtyid)
    {
        $model = $this->findModel($realtyid);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'realtyid' => $model->realtyid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Realty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $realtyid Realtyid
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($realtyid)
    {
        $this->findModel($realtyid)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Realty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $realtyid Realtyid
     * @return Realty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($realtyid)
    {
        if (($model = Realty::findOne(['realtyid' => $realtyid])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
