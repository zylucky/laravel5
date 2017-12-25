<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'login',
        'logout',
        '/sendMessage',
        '/readMessage',
        '/receiveMessage/{send_to_id}/sys/{sys}',
        '/api/v1/owner',
        '/api/v1/owner/login',
        '/api/v1/owner/verifyCode',
        '/api/v1/owner/resetPassword',
        '/api/v1/owner/editPassword',
        '/api/v1/owner/createOwner',
    ];
}
