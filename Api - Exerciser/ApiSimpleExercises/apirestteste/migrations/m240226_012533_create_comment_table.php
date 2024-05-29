<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m240226_012533_create_comment_table extends Migration
{
    /**{{%video}}
     *
     *
     *
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'textcomment' => $this->text()->notNull(),
            'id_video' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('fk_comment_video', '{{%comment}}','id_video', '{{%video}}','id','CASCADE', 'CASCADE');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comments_video', '{{%comment}}');
        $this->dropTable('{{$comment}}');
    }
}
