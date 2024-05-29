<?php

use yii\db\Migration;

/**
 * Class m240216_183312_pokemonstable
 */
class m240216_183312_pokemonstable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("pokemons", [
            'id' => $this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'type'=>$this->string(),
            'idTrainer'=>$this->integer()->notNull()
        ]);
        $this->addForeignKey("nucleo_fk", 'pokemons', 'idTrainer', 'trainer','id','CASCADE','CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('idTrainer', 'pokemons');
        $this->dropTable('pokemons');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240216_183312_pokemonstable cannot be reverted.\n";

        return false;
    }
    */
}
