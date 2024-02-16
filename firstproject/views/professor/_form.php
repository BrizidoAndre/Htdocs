<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\Professor $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="professor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'materia')->textInput(['maxlength' => true]) ?>

    <?php  $models = \app\models\Usuario::find()->orderBy("nome")->all()                         ?>

    <?php  $map = \yii\helpers\ArrayHelper::map($models,'id', 'nome')                         ?>

    <?= $form->field($model, 'idLogin')->dropDownList($map, ['prompt' => 'Selecione um Usuário'])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
