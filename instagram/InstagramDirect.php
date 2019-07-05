<?php

namespace app\instagram;
use app\models\Thread;
use app\models\ThreadItem;
use \app\models\Media;

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
        $oThread->save();       
        $oThread->link('users', $this->oUser);
        
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
            
            $this->addMedia($oThreadItemInstagram);
        }
        $oThreadItem->text = $oThreadItemInstagram->getText();
        $oThreadItem->save();
        
        $oUserInstagram = $this->oInstagram->people->getInfoById($oThreadItemInstagram->getUserId())->getUser();

        \Yii::$app->instagram->updateUser($oUserInstagram);
    }
    
    public function addMedia(\InstagramAPI\Response\Model\DirectThreadItem $oThreadItemInstagram) {
        $oThreadItemMedia = $oThreadItemInstagram->getMedia();
        if(!$oThreadItemMedia or !$oThreadItemMedia->isMediaType()){
            return;
        }
        if($oThreadItemMedia->isImageVersions2()){
            $sType = Media::TYPE_IMAGE;
            $aImages =  $oThreadItemMedia->getImageVersions2()->getCandidates();
            $aUrls = [];
            foreach ($aImages as $oImage){
                $aUrls[] = $oImage->getUrl();
            }
            
        }        
        if($oThreadItemMedia->isAudio()){
            $sType = Media::TYPE_AUDIO;
            $aUrls = [$oThreadItemMedia->getAudio()->getAudioSrc()];
        }
        if($oThreadItemMedia->isVideoVersions()){
            $sType = Media::TYPE_VIDEO;
            $aVideos = $oThreadItemMedia->getVideoVersions();
            foreach ($aVideos as $oVideo ) {
                $aUrls[] = $oVideo->getUrl();
            }
        }
        
        $oMedia = new Media();
        $oMedia->type = $sType;
        $oMedia->urls = $aUrls;
        $oMedia->thread_item_id = $oThreadItemInstagram->getItemId();
        
        $oMedia->save();
    }
}