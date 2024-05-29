<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\RealtySearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="realty-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'realtyid') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'num_rooms') ?>

    <?= $form->field($model, 'offer_type')->checkbox() ?>

    <?= $form->field($model, 'rooms_qt') ?>

    <?php // echo $form->field($model, 'toilet_qt') ?>

    <?php // echo $form->field($model, 'parkingspace_qt') ?>

    <?php // echo $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'neighborhoodId') ?>

    <?php // echo $form->field($model, 'categoryid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
