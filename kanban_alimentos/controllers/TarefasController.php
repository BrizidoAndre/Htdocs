<?php

namespace app\controllers;

use app\models\Tarefas;
use app\models\TarefasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TarefasController implements the CRUD actions for Tarefas model.
 */
class TarefasController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tarefas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TarefasSearch();
        $aFazer = $searchModel->search($this->request->queryParams, 1);
        $fazendo = $searchModel->search($this->request->queryParams, 2);
        $pronto = $searchModel->search($this->request->queryParams, 3);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'aFazer' => $aFazer->getModels(),
            'fazendo' => $fazendo->getModels(),
            'pronto' => $pronto->getModels(),
        ]);
    }

    /**
     * Displays a single Tarefas model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tarefas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tarefas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                \Yii::$app->session->setFlash('info', 'cadastro concluído com sucesso');
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
     * Updates an existing Tarefas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->goHome();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionStatus()
    {
        echo '<pre>' . print_r($_POST, true) . '</pre>';
        $id = \Yii::$app->request->getBodyParam('id');
        $status_id = \Yii::$app->request->getBodyParam('status');

        $tarefa = Tarefas::findOne($id);
        if (!$tarefa) {
            $this->goHome();
        }
        $tarefa->id_status = $status_id;
        $tarefa->save();

        return $this->goHome();
    }

    /**
     * Deletes an existing Tarefas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tarefas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tarefas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tarefas::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
