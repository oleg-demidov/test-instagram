<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Media
 *
 * @author oleg
 */
class Media extends \yii\redis\ActiveRecord{
    
    const TYPE_IMAGE = 'image';
    const TYPE_AUDIO = 'audio';
    const TYPE_VIDEO = 'video';
    
    public static function tableName() {
        return 'media';
    }
}
