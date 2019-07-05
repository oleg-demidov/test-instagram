<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Profile '. $oUser->username;
?>

<h1><?php echo $this->title ?></h1>

<div class="profile-index">
    <ul class="nav nav-pills">
        <li role="presentation"><a href="<?php echo Url::to(['message/index'])?>">Messages</a></li>
    </ul>

    
</div>
