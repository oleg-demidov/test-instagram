<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m190704_085700_thread_item
 */
class m190704_085700_thread_item extends Migration
{
    
// Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('thread_item', [
            'id' => $this->string(),
            'text' => $this->string(1000)->defaultValue(null),
            'thread_id'  => $this->string(),
            'user_id'  => $this->bigInteger(20)
        ]);
        
        $this->addPrimaryKey('id', 'thread_item', 'id');
    }

    public function down()
    {
        $this->dropTable('thread_item');
    }
}
