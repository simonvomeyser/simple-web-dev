<?php

return [
    // todo: Find a cleaner way to do this
    'location' => env('APP_ENV') === 'testing' ? base_path('tests/Fixtures/posts') : resource_path('views/posts')
];
