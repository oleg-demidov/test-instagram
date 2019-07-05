<?php

use yii\db\Migration;

/**
 * Class m190705_042013_media
 */
class m190705_042013_media extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('media', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'urls' => $this->text(),
            'thread_item_id' => $this->string()
        ]);
    }

    public function down()
    {
        $this->dropTable('media');
    }
}
