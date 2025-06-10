<?php

use app\models\Tarefas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TarefasSearch $searchModel */
/** @var Tarefas [] $aFazer */
/** @var Tarefas [] $fazendo */
/** @var Tarefas [] $pronto */

$this->title = 'Tarefas';
?>
<div class="tarefas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col">
            <h2>A Fazer</h2>
            <?php foreach ($aFazer as $tarefa): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Descrição: <?= $tarefa->descricao ?></p>
                        <p class="card-text">Setor: <?= $tarefa->setor ?></p>
                        <p class="card-text">Prioridade: <?= $tarefa->prioridade->prioridade ?></p>
                        <p class="card-text">Vinculado a: <?= $tarefa->user->nome ?></p>

                        <?= Html::a('Editar', ['tarefas/update', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>
                        <?= Html::a('Excluir', ['tarefas/delete', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light btn-delete',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::beginForm(['tarefas/status']) ?>

                        <div class="d-none">
                            <?= Html::hiddenInput('id', $tarefa->id) ?>
                        </div>

                        <div class="form-check my-3">
                            <?= Html::radio('status', $tarefa->id_status === 1, ['label' => 'A fazer', 'value' => 1]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 2, ['label' => 'Fazendo', 'value' => 2]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 3, ['label' => 'Pronto', 'value' => 3]) ?>
                        </div>

                        <?= Html::submitButton('Alterar status', ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::endForm() ?>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
        <div class="col">
            <h2>Fazendo</h2>
            <?php foreach ($fazendo as $tarefa): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Descrição: <?= $tarefa->descricao ?></p>
                        <p class="card-text">Setor: <?= $tarefa->setor ?></p>
                        <p class="card-text">Prioridade: <?= $tarefa->prioridade->prioridade ?></p>
                        <p class="card-text">Vinculado a: <?= $tarefa->user->nome ?></p>

                        <?= Html::a('Editar', ['tarefas/update', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>
                        <?= Html::a('Excluir', ['tarefas/delete', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light btn-delete',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::beginForm(['tarefas/status']) ?>

                        <div class="d-none">
                            <?= Html::hiddenInput('id', $tarefa->id) ?>
                        </div>

                        <div class="form-check my-3">
                            <?= Html::radio('status', $tarefa->id_status === 1, ['label' => 'A fazer', 'value' => 1]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 2, ['label' => 'Fazendo', 'value' => 2]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 3, ['label' => 'Pronto', 'value' => 3]) ?>
                        </div>

                        <?= Html::submitButton('Alterar status', ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::endForm() ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col">
            <h2>Pronto</h2>
            <?php foreach ($pronto as $tarefa): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Descrição: <?= $tarefa->descricao ?></p>
                        <p class="card-text">Setor: <?= $tarefa->setor ?></p>
                        <p class="card-text">Prioridade: <?= $tarefa->prioridade->prioridade ?></p>
                        <p class="card-text">Vinculado a: <?= $tarefa->user->nome ?></p>

                        <?= Html::a('Editar', ['tarefas/update', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>
                        <?= Html::a('Excluir', ['tarefas/delete', 'id' => $tarefa->id], ['class' => 'btn valid-background text-light btn-delete',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::beginForm(['tarefas/status']) ?>

                        <div class="d-none">
                            <?= Html::hiddenInput('id', $tarefa->id) ?>
                        </div>

                        <div class="form-check my-3">
                            <?= Html::radio('status', $tarefa->id_status === 1, ['label' => 'A fazer', 'value' => 1]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 2, ['label' => 'Fazendo', 'value' => 2]) ?>
                            <?= Html::radio('status', $tarefa->id_status === 3, ['label' => 'Pronto', 'value' => 3]) ?>
                        </div>

                        <?= Html::submitButton('Alterar status', ['class' => 'btn valid-background text-light',
                            'style' => 'background: #0056b3']) ?>

                        <?= Html::endForm() ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>


<?php
    $this->registerJs("
        $('.btn-delete').on('click',function(ev){
            if (!window.confirm('Você tem certeza que deseja excluir esse item?')) {
                ev.preventDefault()
            }
        })
    ");
?>
