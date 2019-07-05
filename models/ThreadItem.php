<?php

namespace app\models;
use app\models\Thread;
use app\models\Media;
/**
 * Description of Thread
 *
 * @author oleg
 */
class ThreadItem extends \yii\db\ActiveRecord{
    
    public static function tableName() {
        return 'thread_item';
    }
    
    public function getThread() {
        return Thread::findOne($this->thread_id);
    }
    
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    public function getMedia() {
        return $this->hasMany(Media::class, ['thread_item_id' => 'id']);
    }
}
