<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bank_service}}`.
 */
class m250803_134837_create_bank_service_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%bank_service}}', [
            'bank_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull(),
            'PRIMARY KEY(bank_id, service_id)',
        ]);
        $this->addForeignKey('fk_bank_service_bank', '{{%bank_service}}', 'bank_id', '{{%bank}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_bank_service_service', '{{%bank_service}}', 'service_id', '{{%service}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_bank_service_bank', '{{%bank_service}}');
        $this->dropForeignKey('fk_bank_service_service', '{{%bank_service}}');
        $this->dropTable('{{%bank_service}}');
    }
}
