<?php

Route::get('/mail-config-test', function () {
    return response()->json([
        'default_mailer' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'username' => config('mail.mailers.smtp.username'),
        'encryption' => config('mail.mailers.smtp.encryption'),
        'password_length' => strlen(config('mail.mailers.smtp.password') ?? ''),
        'from_address' => config('mail.from.address'),
    ]);
});