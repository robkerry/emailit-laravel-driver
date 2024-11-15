<?php

return [
    'api_key' => env('EMAILIT_API_KEY'),
    'host' => env('EMAILIT_API_HOST', 'api.emailit.com'),
    'protocol' => env('EMAILIT_API_PROTO', 'https'),
    'api_path' => env('EMAILIT_API_PATH', 'v1'),
];
