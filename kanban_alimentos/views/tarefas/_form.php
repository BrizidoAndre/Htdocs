<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tarefas $model */
/** @var yii\widgets\ActiveForm $form */
$users = \app\models\Users::find()->all();
$users = \yii\helpers\ArrayHelper::map($users,'id','nome');
$priorities = \app\models\Prioridades::find()->all();
$priorities = \yii\helpers\ArrayHelper::map($priorities,'id','prioridade');
?>

<div class="tarefas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'setor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_user')->dropDownList($users) ?>

    <?= $form->field($model, 'id_prioridade')->dropDownList($priorities) ?>

    <div class="form-group">
        <?= Html::submitButton('Cadastrar', ['class' => 'btn valid-background text-light',
            'style' => 'background: #0056b3']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
