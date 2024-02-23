<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="body-content">

        <h1>Feed de animais via REST API</h1>

        <?php foreach ($info as $row) : ?>

        <p>ID: <?= $row['id'] ?></p>
        <p>Espécie: <?= $row['Nome alternativo'] ?></p>
        <p>SOM: <?= $row['Som'] ?></p>

        <?php endforeach; ?>

    </div>
</div>
