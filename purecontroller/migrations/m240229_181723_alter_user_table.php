<?php

use yii\db\Migration;

/**
 * Class m240229_181723_alter_user_table
 */
class m240229_181723_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240229_181723_alter_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240229_181723_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
