<?php

namespace app\instagram;
use app\models\Thread;
use app\models\ThreadItem;
/**
 * Description of Instagram
 *
 * @author oleg
 */
class InstagramDirect  extends InstagramJob{
    

    /**
     * Обновление нитей переписки
     */
    public function getThreads() {
        $aThreads = $this->oInstagram->direct->getInbox()->getInbox()->getThreads();
        
        foreach ($aThreads as $oThreadInstagram) {
            $this->updateThread($oThreadInstagram);
        }        
    }

    public function updateThread($oThreadInstagram) {
        if(!$oThreadInstagram){
            reuturn;
        }
        
        if(!$oThread = Thread::findOne($oThreadInstagram->getThreadId())){ 
            $oThread = new Thread;
            $oThread->id = $oThreadInstagram->getThreadId();
        }
        $oThread->is_group = $oThreadInstagram->getIsGroup();
        $oThread->title = $oThreadInstagram->getThreadTitle();
        $oThread->link('users', $this->oUser);
        $oThread->save();       
        
        foreach ($oThreadInstagram->getItems() as $oThreadItemInstagram) {
            $this->updateThreadItem($oThreadItemInstagram, $oThread->id);
        }
        
    }
    
    public function updateThreadItem($oThreadItemInstagram, $sThreadId) {
        if(!$oThreadItem = ThreadItem::findOne($oThreadItemInstagram->getItemId())){
            $oThreadItem = new ThreadItem;
            $oThreadItem->id = $oThreadItemInstagram->getItemId();
            $oThreadItem->thread_id = $sThreadId;
            $oThreadItem->user_id = $oThreadItemInstagram->getUserId();
        }
        $oThreadItem->text = $oThreadItemInstagram->getText();
        $oThreadItem->save();
        
        $oUserInstagram = $this->oInstagram->people->getInfoById($oThreadItemInstagram->getUserId())->getUser();

        \Yii::$app->instagram->updateUser($oUserInstagram);
    }
}