<?php

use yii\db\Migration;

/**
 * Class m240216_184111_eggs
 */
class m240216_184111_eggs extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('eggs', [
            'id'=>$this->primaryKey(),
            'color'=>$this->string(),
            'timeHatch'=>$this->integer(),
            'idPokemon'=>$this->integer()->notNull(),
        ]);
        $this->addForeignKey('idPokemonFk', 'eggs', 'idPokemon', 'pokemons','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("idPokemonFk","eggs");
        $this->dropTable("eggs");

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240216_184111_eggs cannot be reverted.\n";

        return false;
    }
    */
}
