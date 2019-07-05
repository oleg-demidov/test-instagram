<?php


/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Messsages to '. $oUser->username;
?>

<h1><?php echo $this->title ?></h1>

<div class="profile-index">
    
    <div class="threads mt-3">
        <?php 

            foreach ($aThreads as $oThread) {
                ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <a href="<?php echo Url::to(['message/thread', 'id' => $oThread->id]) ?>"><?php echo $oThread->title ?></a>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
</div>
