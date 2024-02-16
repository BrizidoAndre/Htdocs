<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pokemons $model */
/** @var yii\widgets\ActiveForm $form */

$treinadores = \app\models\Trainer::find()->orderBy('name')->all();

$arrayTreinadores = \yii\helpers\ArrayHelper::map($treinadores,'id','name')


?>

<div class="pokemons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idTrainer')->
    dropDownList($arrayTreinadores,["prompt" => "Selecione um treinador"])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
