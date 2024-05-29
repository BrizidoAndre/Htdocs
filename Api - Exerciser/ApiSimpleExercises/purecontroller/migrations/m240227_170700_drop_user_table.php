<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%user}}`.
 */
class m240227_170700_drop_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%user}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
