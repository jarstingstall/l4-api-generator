<?php

return [

    'driver' => 'eloquent',

    'prefix' => 'v1',

    'resources' => [
        'users',
        'messages',
        'call_events',
        'message_events'
    ]

];