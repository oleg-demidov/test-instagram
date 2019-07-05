<?php

namespace app\models;
use app\models\ThreadItem;
/**
 * Description of Thread
 *
 * @author oleg
 */
class Thread extends \yii\db\ActiveRecord{
    
    public static function tableName() {
        return 'thread';
    }
    
    public function getThreadItems() {
        return $this->hasMany(ThreadItem::class, ['thread_id' => 'id']);
    }
    
    public function getUsers() {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_thread', ['thread_id' => 'id']);
    }
}
