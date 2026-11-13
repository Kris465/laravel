<?php

return [

    /*
    | Учётные данные администратора задаются в .env. Значения читаются здесь,
    | чтобы AdminUserSeeder работал и при включённом config:cache.
    */

    'admin_email' => env('ADMIN_EMAIL'),

    'admin_password' => env('ADMIN_PASSWORD'),

];
