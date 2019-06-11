<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%printers}}`.
 */
class m190611_070816_create_printers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('printers', [
            'id' => $this->primaryKey(),
            'printer_id'=>$this->string(256)->notNull(),
            'printer_name'=>$this->string(256)->notNull(),
            'description'=>$this->text(),
            'connect_string'=>$this->string(256)->notNull(),
            'created_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_on'=>$this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('printers');
    }
}
