<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Realty $model */

$this->title = 'Update Realty: ' . $model->realtyid;
$this->params['breadcrumbs'][] = ['label' => 'Realties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->realtyid, 'url' => ['view', 'realtyid' => $model->realtyid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="realty-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
