<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_job}}`.
 */
class m240506_180619_create_user_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_job}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'job_id' => $this->integer()->notNull()

        ]);

        $this->addForeignKey('fk_user_userjob', 'user_job', 'user_id', 'users', 'id');
        $this->addForeignKey('fk_job_userjob', 'user_job', 'job_id', 'jobs', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_job}}');
    }
}
