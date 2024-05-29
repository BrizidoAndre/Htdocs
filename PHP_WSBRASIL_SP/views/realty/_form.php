<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Realty $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="realty-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_rooms')->textInput() ?>

    <?= $form->field($model, 'offer_type')->checkbox() ?>

    <?= $form->field($model, 'rooms_qt')->textInput() ?>

    <?= $form->field($model, 'toilet_qt')->textInput() ?>

    <?= $form->field($model, 'parkingspace_qt')->textInput() ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'neighborhoodId')->textInput() ?>

    <?= $form->field($model, 'categoryid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
