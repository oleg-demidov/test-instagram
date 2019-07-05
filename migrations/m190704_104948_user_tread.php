<?php

use yii\db\Migration;

/**
 * Class m190704_104948_user_tread
 */
class m190704_104948_user_tread extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user_thread', [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(),
            'thread_id'  => $this->string(500)
        ]);
        
    }

    public function down()
    {
        return $this->dropTable('user_thread');
    }
}
