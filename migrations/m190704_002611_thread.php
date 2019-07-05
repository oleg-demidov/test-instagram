<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m190704_002611_thread
 */
class m190704_002611_thread extends Migration
{
    

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('thread', [
            'id' => $this->string(),
            'title' => $this->string()->defaultValue(null),
            'is_group'  => $this->boolean(),
        ]);
        
        $this->addPrimaryKey('id', 'thread', 'id');
    }

    public function down()
    {
        $this->dropTable('thread');
    }
}
