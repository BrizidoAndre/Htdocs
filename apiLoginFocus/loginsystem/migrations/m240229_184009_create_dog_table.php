<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%dog}}`.
 */
class m240229_184009_create_dog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%dog}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'color' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%dog}}');
    }
}
