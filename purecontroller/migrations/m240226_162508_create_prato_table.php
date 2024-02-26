<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prato}}`.
 */
class m240226_162508_create_prato_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prato}}', [
            'id' => $this->primaryKey(),
            'nome_prato' => $this->string(150)->notNull(),
            'quantidade_gramas' => $this->bigInteger()->notNull(),
            'id_restaurante' => $this->integer()->notNull(),


        ]);

        $this->addForeignKey('fk_prato_restaurante', '{{%prato}}','id_restaurante', '{{%restaurante}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%prato}}');
        $this->dropForeignKey('fk_prato_restaurante', '{{%prato}}');
    }
}
