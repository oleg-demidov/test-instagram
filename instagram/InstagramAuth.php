<?php

namespace app\instagram;
use app\models\User;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramAuth  extends InstagramJob{
    

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

        $oUser = User::findOne([
            'username' => $oUserInstagram->getUsername()
        ]);
        
        if(!$oUser){
            $oUser = new User();
            $oUser->username = $oUserInstagram->getUsername();
            $oUser->password = $password;
            $oUser->instagram_id = $oUserInstagram->getPk();
            if($oUser->validate()){
                $oUser->save();
            }
        }
    }
    
    public function logout() {
        $this->oInstagram->logout();
    }

}