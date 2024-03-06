<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%skills}}`.
 */
class m240306_185345_create_skills_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('skills', [
            'id' => $this->primaryKey(),
            'level_id' => $this->integer()->notNull(),
            'employee_id' => $this->integer()->notNull(),
            'competence_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_skills_level','skills','level_id','levels','id');
        $this->addForeignKey('fk_skills_employee','skills','employee_id','employees','id');
        $this->addForeignKey('fk_skills_competence','skills','competence_id','competences','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('skills');
    }
}
