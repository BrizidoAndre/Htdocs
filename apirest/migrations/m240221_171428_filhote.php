<?php

use yii\db\Migration;

/**
 * Class m240221_171428_filhote
 */
class m240221_171428_filhote extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('filhote',[
            'id'=>$this->primaryKey(),
            'nome' => $this->string(),
            'nascimento' =>$this->date(),
            'pai'=>$this->integer()
        ]);
        $this->addForeignKey('idAnimal_fk', 'filhote','pai','animais','id','CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('filhote');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240221_171428_filhote cannot be reverted.\n";

        return false;
    }
    */
}
