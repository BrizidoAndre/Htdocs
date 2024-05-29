<?php

use yii\db\Migration;

/**
 * Class m240229_181948_update_user_table
 */
class m240229_181948_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->alterColumn('users','access_token','string');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
            $this->alterColumn('users','access_token','string not null');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240229_181948_update_user_table cannot be reverted.\n";

        return false;
    }
    */
}
