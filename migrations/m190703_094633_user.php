<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190703_094633_user
 */
class m190703_094633_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->string(),
            'username' => $this->string()->defaultValue(null),
            'auth_key'  => $this->string(500)->defaultValue(null),
            'access_token' => $this->string(500)->defaultValue(null),
            'password' => $this->string(500)->defaultValue(null),
        ]);
        
        $this->addPrimaryKey('id', 'user', 'id');
    }

    public function down()
    {
        return $this->dropTable('user');
    }
    
}
