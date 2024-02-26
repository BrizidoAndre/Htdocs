<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%restaurante}}`.
 */
class m240226_162442_create_restaurante_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%restaurante}}', [
            'id' => $this->primaryKey(),
            'nome_fantasia' => $this->string(200)->notNull(),
            'endereco' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%restaurante}}');
    }
}
