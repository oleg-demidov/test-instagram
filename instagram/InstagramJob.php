<?php

namespace app\instagram;
use yii\base\BaseObject;
use yii\queue\JobInterface;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramJob extends BaseObject implements JobInterface{
        
    protected $oInstagram;
    /*
     * Метод который нужно вызвать
     */
    public $method = [];
    /*
     * Параметры которые передать в метод
     */
    public $params = [];
            
    public $oUser;
    /**
     * Логинится и Вызывает метод копмпонента instagram
     * @param type $queue
     */
    public function execute($queue) { 

        $this->oInstagram = \Yii::$app->instagram->getInstance();    

        if(!$this->oInstagram->isMaybeLoggedIn){
            if(!$this->oUser){
                throw new \yii\queue\InvalidJobException('No user in job');
            }
            $this->login($this->oUser->username, $this->oUser->password);
        }
        /*
         * Попытаться вызвать дочерние методы
         */
        if(!method_exists($this, $this->method)){
            throw new \yii\queue\InvalidJobException('Instagram method '.$this->method.' not exist in '. get_class($this));
        }

        return call_user_func_array([$this, $this->method], $this->params);
    }

    /**
     * Передаем любые методы в Очередь на вызов Instagram
     * @param type $name
     * @param type $params
     */
    public function login($username, $password) {

        $oLoginResponse = $this->oInstagram->login($username, $password);
        
        if(is_null($oLoginResponse) and $this->oInstagram->isMaybeLoggedIn){
            /*
             * Пытаемся получить залогиненого пользователя
             */
            $oUserInstagram = $this->oInstagram->account->getCurrentUser()->getUser();
        }else{
            $oUserInstagram = $oLoginResponse->getLoggedInUser();
        }
        
        if (!$oUserInstagram) { 
            throw new \yii\base\Exception('Instagram Login error');
        }

    }
    
    public function logout() {
        $this->oInstagram->logout();
    }
}
