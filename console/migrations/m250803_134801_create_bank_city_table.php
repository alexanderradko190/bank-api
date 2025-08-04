<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bank_city}}`.
 */
class m250803_134801_create_bank_city_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%bank_city}}', [
            'bank_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'PRIMARY KEY(bank_id, city_id)',
        ]);
        $this->addForeignKey('fk_bank_city_bank', '{{%bank_city}}', 'bank_id', '{{%bank}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bank_city_city', '{{%bank_city}}', 'city_id', '{{%city}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_bank_city_bank', '{{%bank_city}}');
        $this->dropForeignKey('fk_bank_city_city', '{{%bank_city}}');
        $this->dropTable('{{%bank_city}}');
    }
}
