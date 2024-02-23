<?php

use yii\db\Migration;

/**
 * Class m240219_161700_uservalidation
 */
class m240219_161700_uservalidation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('usuarios',[
            'id'=>$this->primaryKey(),
            'nomeusuario'=>$this->string()->unique()->notNull(),
            'senha'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240219_161700_uservalidation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240219_161700_uservalidation cannot be reverted.\n";

        return false;
    }
    */
}
