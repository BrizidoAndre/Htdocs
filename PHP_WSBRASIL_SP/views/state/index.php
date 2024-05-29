<?php

use app\models\State;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\State $model */

$this->title = 'Estados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-index">

    <h1><?= $this->title?></h1>

    <div class="state-form">

        <?php $form = ActiveForm::begin([
                'action' => ['state/create'],
                'method' => 'POST'
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'acronym')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Criar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                    'label' => 'Estado',
                    'value' => 'name'
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, State $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'stateId' => $model->stateId]);
                 }
            ],
        ],
        'emptyText' => '<p class="display-6 text-center">Nenhum estado cadastrado</p>'
    ]); ?>


</div>
