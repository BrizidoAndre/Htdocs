<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%competence_user}}`.
 */
class m240506_181422_create_competence_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%competence_user}}', [
            'id' => $this->primaryKey(),
            'competence_id' => $this->integer()->notNull(),
            'level_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'job_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_competence_competenceUser','competence_user', 'competence_id', 'competences', 'id');
        $this->addForeignKey('fk_level_competenceUser', 'competence_user', 'level_id', 'levels', 'id');
        $this->addForeignKey('fk_user_competenceUser', 'competence_user', 'user_id', 'user_job','user_id');
        $this->addForeignKey('fk_job_competenceUser', 'competence_user', 'job_id', 'user_job','job_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%competence_user}}');
    }
}
