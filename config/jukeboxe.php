<?php

return [
    'priorities' => [
        'guest_added' => env('TRACK_PRIORITY_GUEST_ADDED', 100),
        'reserve' => env('TRACK_PRIORITY_RESERVE', 50),
    ],
];
