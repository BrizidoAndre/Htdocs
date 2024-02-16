<?php

use yii\db\Migration;

/**
 * Class m240216_182428_pokemons
 */
class m240216_182428_pokemons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('trainer', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string(),
            'email'=>$this->string(),
            'medals'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("trainer");

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240216_182428_pokemons cannot be reverted.\n";

        return false;
    }
    */
}
