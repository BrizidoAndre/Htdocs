<?php

use app\models\Amenity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var \yii\base\Model $model */

$this->title = 'Amenities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="amenity-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="amenity-form">

<!--        É AQUI QUE COMEÇA A LÓGICA DE CADASTRO DE Comodidades-->
        <?php $form = ActiveForm::begin([
//                aqui estou especificando que o método do form será a função actionCreate do AmenityController
            'action' => ['amenity/create']
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


    <h2 class="text-center">Comodidades já cadastradas</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Amenity $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'amenityId' => $model->amenityId]);
                }
            ],

        ],
        'showOnEmpty' => false,
        'emptyText' => '<p class="display-6 text-center">Nenhuma comodidade cadastrada</p>'
    ]); ?>


</div>
