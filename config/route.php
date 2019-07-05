<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'profile' => 'profile/index',
        "threads" => 'message/index',
        "thread/<id:\d+>" => 'message/thread',
    ],
];
