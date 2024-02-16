<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Eggs $model */
/** @var yii\widgets\ActiveForm $form */

$eggs = \app\models\Pokemons::find()->orderBy('name')->all();

$arrayEggs = \yii\helpers\ArrayHelper::map($eggs,"id","name")

?>

<div class="eggs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timeHatch')->textInput() ?>

    <?= $form->field($model, 'idPokemon')->dropDownList($arrayEggs,['prompt' => 'Selecione o pokemon']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
