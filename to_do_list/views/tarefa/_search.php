<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TarefaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'IdTarefa') ?>

    <?= $form->field($model, 'Descricao') ?>

    <?= $form->field($model, 'Setor') ?>

    <?= $form->field($model, 'DataCadastro') ?>

    <?= $form->field($model, 'IdUsuario') ?>

    <?php // echo $form->field($model, 'IdPrioridade') ?>

    <?php // echo $form->field($model, 'IdStatus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
