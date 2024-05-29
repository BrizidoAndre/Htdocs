<?php

use app\models\City;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\City $model */

$this->title = 'Cidades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="city-form">

        <?php $form = ActiveForm::begin([
            'action' => ['city/create'],
            'method' => 'post'
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'stateid')->dropDownList(
            ArrayHelper::map(\app\models\State::find()->all(), 'stateId', 'name'),
            [
                'prompt' => 'Selecione o Estado',
                'text' => 'Estado'
            ]
        )->label('Estado') ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Cidade',
                'value' => 'name'
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, City $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'cityId' => $model->cityId]);
                }
            ],
        ],

        'showOnEmpty' => true,
        'emptyText' => '<p class="display-6 text-center">Nenhuma comodidade cadastrada</p>'
    ]); ?>


</div>
