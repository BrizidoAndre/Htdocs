<?php

use yii\db\Migration;

/**
 * Class m240219_173711_alterusers
 */
class m240219_173711_alterusers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('usuario','email', 'string unique');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('usuario','email', 'string');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240219_173711_alterusers cannot be reverted.\n";

        return false;
    }
    */
}
