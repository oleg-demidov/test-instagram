<?php

namespace app\models;

/**
 * Description of userSessions
 *
 * @author oleg
 */
class UserSession extends \yii\db\ActiveRecord{
    
    
    public static function tableName() {
        return 'user_sessions';
    }
}
