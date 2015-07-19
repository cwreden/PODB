<?php

namespace OpenCoders\Podb;


class Configurations
{
    const NAME = 'podb.name';

    const REQUEST_LIMIT_RESET_INTERVAL = 'podb.requestLimit.resetInterval';
    const REQUEST_LIMIT = 'podb.requestLimit.limit';
    const REQUEST_LIMIT_AUTHENTICATED = 'podb.requestLimit.authenticatedLimit';

    const REGISTRATION_VALIDATE_EMAIL = 'podb.registration.email_validation';
    const REGISTRATION_VALIDATE = 'podb.registration.account_validation';

    const PASSWORD_SALT = 'podb.password.salt';
}
