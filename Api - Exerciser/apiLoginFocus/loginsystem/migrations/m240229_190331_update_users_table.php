<?php

use yii\db\Migration;

/**
 * Class m240229_190331_update_users_table
 */
class m240229_190331_update_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'username','string unique not null');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240229_190331_update_users_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240229_190331_update_users_table cannot be reverted.\n";

        return false;
    }
    */
}
