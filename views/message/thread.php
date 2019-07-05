<?php


/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Thread '. $oThread->title;
?>

<h1><?php echo $this->title ?></h1>

<div class="thread-items mt-3">
    <?php 

        foreach ($oThread->getThreadItems()->all() as $oThreadItem) {
            ?>
            
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo $oThreadItem->getUser()->one()->username;?></div>
                    <div class="panel-body">
                        <?php 
                            echo $oThreadItem->text;                            print_r($oThreadItem->getMedia()->all());
                            foreach ($oThreadItem->getMedia() as $oMedia) {
//                                print_r($oMedia);
                            }
                        ?>
                    </div>
                </div>
            <?php
        }
    ?>
</div>
