<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video}}`.
 */
class m240223_202613_create_video_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'minutes_lenght' => $this->integer()->notNull(),
            'uploaded_at' => $this->date()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%video}}');
    }



}
