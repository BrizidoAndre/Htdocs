<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tarefas $model */

$this->title = 'Editando tarefa: ' . $model->id;
?>
<div class="tarefas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
