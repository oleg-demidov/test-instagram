<?php

namespace app\widgets;
use yii\base\Widget;
/**
 * Description of MediaWidget
 *
 * @author oleg
 */
class MediaWidget extends \yii\base\Widget{
    
    public $oMedia;


    public function run() { 
        if(!$this->oMedia){
            return;
        }
        
        return  $this->render('media-'.$this->oMedia->type, [
           'oMedia' => $this->oMedia
        ]);
    }   
    
}
