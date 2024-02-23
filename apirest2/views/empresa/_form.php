<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Empresa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomefantasia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endereço')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'historia')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
