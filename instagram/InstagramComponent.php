<?php


namespace app\instagram;
use yii\base\Component;
use InstagramAPI\Instagram;
use app\models\User;
use app\models\UserSession;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramComponent  extends Component{
    
       
    public $storageConf = [];
    
    public $debug = false;
    
    public $truncatedDebug = false;
    
    public $console = false;
    /*
     * Объект инстаграм
     */
    private $oInstagram;

    public function init() {
        parent::init();
        /*
         * Инициализируем объект
         */
        if (!$this->console) {
            /*
             * Этот параметр не нужен для консоли
             */
            Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        }        
        
        $this->oInstagram = new Instagram(
            $this->debug,
            $this->truncatedDebug,
            $this->storageConf
        );
        
    }
    
    public function getInstance() {
        return $this->oInstagram;
    }

        
    /**
     * Логинит пользователя когда появилась сессия
     * @param type $username
     * @param type $password
     * @return type
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
        
        $oUser = $this->updateUser($oUserInstagram, $password);
        
        \Yii::$app->user->login($oUser);
        
        return $oUser;
    }
    /**
     * Создает пользователя если его нет
     * @param type $oUserInstagram
     * @param type $password добавляется если пользователь есть
     * @return User
     */
    public function updateUser($oUserInstagram, $password = 'null') {
        
        if(!$oUser = User::findOne([
                    'username' => $oUserInstagram->getUsername()
                ])){
            $oUser = new User();
            $oUser->username = $oUserInstagram->getUsername();
            $oUser->id = $oUserInstagram->getPk();
        }

        $oUser->password = $password;
         
        if($oUser->validate()){
            $oUser->save();
        }
        return $oUser;
    }

    public function logout($oUser) {
        if($this->oInstagram->isMaybeLoggedIn){
            $this->oInstagram->logout();
        }
        
        UserSession::deleteAll([
            'username' => $oUser->username
        ]);
    }
    
}
