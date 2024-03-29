<?php


/* @var $this yii\web\View */
use yii\helpers\Url;
use app\widgets\MediaWidget;

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
                            echo $oThreadItem->text;  
                            foreach ($oThreadItem->getMedia()->all() as $oMedia) {
                                echo MediaWidget::widget(['oMedia' => $oMedia]);
                            }
                        ?>
                    </div>
                </div>
            <?php
        }
    ?>
</div>
