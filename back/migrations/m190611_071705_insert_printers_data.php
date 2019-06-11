<?php

use yii\db\Migration;

/**
 * Class m190611_071705_insert_printers_data
 */
class m190611_071705_insert_printers_data extends Migration
{
    private function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('printers',[
            'printer_id','printer_name','description','connect_string'],[
            [$this->gen_uuid(),'printer 1','printer description','http://some-ip.com:63587'],
            [$this->gen_uuid(),'printer 2','printer description','http://some-ip.com:63587'],
            [$this->gen_uuid(),'printer 3','printer description','http://some-ip.com:63587'],
            [$this->gen_uuid(),'printer 4','printer description','http://some-ip.com:63587'],
            [$this->gen_uuid(),'printer 5','printer description','http://some-ip.com:63587'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('printers');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_071705_insert_printers_data cannot be reverted.\n";

        return false;
    }
    */
}
