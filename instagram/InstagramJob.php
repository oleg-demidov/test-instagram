<?php

namespace app\instagram;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use InstagramAPI\Instagram;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramJob extends BaseObject implements JobInterface{
    /*
     * Объект библиотеки Instagram
     */
    public $aParamsInstagram = [];
    /*
     * Метод который нужно вызвать
     */
    public $method = [];
    /*
     * Параметры которые передать в метод
     */
    public $params = [];
    
    public $storageConf = [];
    
    public $debug = false;
    
    public $truncatedDebug = false;

    
    /**
     * Вызывает метод копмпонента instagram если тот вызывается
     * @param type $queue
     */
    public function execute($queue) {
        $oInstagram = new Instagram(
            $this->debug, 
            $this->truncatedDebug, 
            $this->storageConf
        );
        return call_user_func_array([$oInstagram, $this->method], $this->params);
    }

}
