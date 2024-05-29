<?php

namespace app\controllers;

use app\models\Amenity;
use app\models\AmenitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AmenityController implements the CRUD actions for Amenity model.
 */
class AmenityController extends Controller
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
     * Lists all Amenity models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AmenitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Amenity();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,

        ]);
    }

    /**
     * Displays a single Amenity model.
     * @param int $amenityId Amenity ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($amenityId)
    {
        return $this->render('view', [
            'model' => $this->findModel($amenityId),
        ]);
    }

    /**
     * Creates a new Amenity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Amenity();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->amenityId = count(Amenity::find()->all()) + 1;
                if ($model->save()) {
                    return $this->redirect(['index', 'amenityId' => $model->amenityId]);
                }
            }
        } else {
            $model->loadDefaultValues()->attributes;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Amenity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $amenityId Amenity ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($amenityId)
    {
        $model = $this->findModel($amenityId);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'amenityId' => $model->amenityId]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Amenity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $amenityId Amenity ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($amenityId)
    {
        $this->findModel($amenityId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Amenity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $amenityId Amenity ID
     * @return Amenity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($amenityId)
    {
        if (($model = Amenity::findOne(['amenityId' => $amenityId])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
