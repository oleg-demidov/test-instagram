<?php


namespace app\instagram;
use yii\base\Component;
use InstagramAPI\Instagram;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramComponent  extends Component{
    
    protected $oInstagram;
    
    public $storageConf = [];
    
    public $debug = false;
    
    public $truncatedDebug = false;


    public function init() {
        parent::init();
        
        /*
         * Убираем ругань на наглость
         */
//        Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
//        /**
//        * Инициализация объекта Instagram;
//        */
//        $this->oInstagram = new Instagram(
//            $this->debug, 
//            $this->truncatedDebug, 
//            $this->storageConf
//        );
        
    }
    
    /**
     * Передаем любые методы в Очередь на вызов Instagram, если они есть
     * @param type $name
     * @param type $params
     */
    public function __call($name, $params) {
       
        if(method_exists(Instagram::class, $name)){
            \Yii::$app->queue->push(new InstagramJob([
                'params' => [
                    'debug' => $this->debug, 
                    'truncatedDebug' => $this->truncatedDebug, 
                    'storageConf' => $this->storageConf
                ],
                'method'     => $name,
                'params'     => $params
            ]));
            return;
        }       
        
        parent::__call($name, $params);
    }

    
}
