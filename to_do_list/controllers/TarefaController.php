<?php

namespace app\controllers;

use app\models\Tarefa;
use app\models\TarefaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TarefaController implements the CRUD actions for Tarefa model.
 */
class TarefaController extends Controller
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
                        'delete' => ['GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tarefa models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TarefaSearch();
        $toDo = $searchModel->search($this->request->queryParams, 1);
        $doing = $searchModel->search($this->request->queryParams, 2);
        $done = $searchModel->search($this->request->queryParams, 3);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'toDo'=>  $toDo->getModels(),
            'doing' => $doing->getModels(),
            'done' => $done->getModels()
        ]);
    }

    /**
     * Displays a single Tarefa model.
     * @param int $IdTarefa Id Tarefa
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($IdTarefa)
    {
        return $this->render('view', [
            'model' => $this->findModel($IdTarefa),
        ]);
    }

    public function actionStatus()
    {

        $taskId = \Yii::$app->request->getBodyParam('IdTarefa');
        $statusId = \Yii::$app->request->getBodyParam('status');
        $task = Tarefa::findOne($taskId);
        $task->IdStatus = $statusId;
        $task->save();
        return $this->redirect(['tarefa/index']);
    }

    /**
     * Creates a new Tarefa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tarefa();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->goHome();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tarefa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $IdTarefa Id Tarefa
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($IdTarefa)
    {
        $model = $this->findModel($IdTarefa);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->goHome();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tarefa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $IdTarefa Id Tarefa
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($IdTarefa)
    {
        $this->findModel($IdTarefa)->delete();

        return $this->goHome();
    }

    /**
     * Finds the Tarefa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $IdTarefa Id Tarefa
     * @return Tarefa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($IdTarefa)
    {
        if (($model = Tarefa::findOne(['IdTarefa' => $IdTarefa])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
