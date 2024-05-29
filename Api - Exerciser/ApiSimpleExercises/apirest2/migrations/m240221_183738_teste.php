<?php

use yii\db\Migration;

/**
 * Class m240221_183738_teste
 */
class m240221_183738_teste extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('empresa', [
            'id'=>$this->primaryKey(),
            'nomefantasia'=>$this->string(),
            'endereço'=>$this->string(),
            'historia'=>$this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('chefe');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240221_183738_teste cannot be reverted.\n";

        return false;
    }
    */
}
