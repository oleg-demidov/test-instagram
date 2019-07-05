<?php

return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        "threads" => 'message/index',
        "thread/<id:\d+>" => 'message/thread',
    ],
];
