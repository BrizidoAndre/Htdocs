<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tarefa $model */
/** @var yii\widgets\ActiveForm $form */
$users = \app\models\Usuario::find()->all();
$priorities = \app\models\Prioridade::find()->all();
$users = \yii\helpers\ArrayHelper::map($users,'IdUsuario','Nome');
$priorities = \yii\helpers\ArrayHelper::map($priorities,'IdPrioridade','Titulo');
?>

<div class="tarefa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Setor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdUsuario')->dropDownList($users) ?>

    <?= $form->field($model, 'IdPrioridade')->dropDownList($priorities) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
