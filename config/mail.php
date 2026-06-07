<?php

return [

    'default' => 'log',

    'mailers' => [
        'log' => [
            'transport' => 'log',
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    'from' => [
        'address' => 'noreply@unitrack.local',
        'name' => env('APP_NAME', 'UniTrack'),
    ],

];
