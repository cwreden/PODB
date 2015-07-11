<?php

namespace OpenCoders\Podb\Security;


class SecurityServices
{

    const SALT_GENERATOR = 'security.generator.salt';
    const RATE_LIMITER = 'security.rate_limiter';
    const RATE_LIMIT_REQUEST_LIMIT = 'podb.requestLimit.limit';
    const RATE_LIMIT_AUTHENTICATED_REQUEST_LIMIT = 'podb.requestLimit.authenticatedLimit';
    const RATE_LIMIT_REQUEST_LIMIT_RESET_INTERVAL = 'podb.requestLimit.resetInterval';
}
