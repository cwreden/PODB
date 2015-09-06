### ToDo´s


#### Basic authentication
<code>

    const REALM = 'Restricted API';

    $username = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    header('WWW-Authenticate: Basic realm="' . self::REALM . '"');
    throw new RestException(401, 'Basic Authentication Required');

</code>


#### Entity audit
<code>

    $auditConfig = new AuditConfiguration();
    $auditConfig->setAuditedEntityClasses(array(
        'OpenCoders\Podb\Persistence\Entity\User',
        'OpenCoders\Podb\Persistence\Entity\Role',
        'OpenCoders\Podb\Persistence\Entity\Language',
        'OpenCoders\Podb\Persistence\Entity\Project',
        'OpenCoders\Podb\Persistence\Entity\Domain',
        'OpenCoders\Podb\Persistence\Entity\Message',
        'OpenCoders\Podb\Persistence\Entity\Translation',
    ));
    $evm = self::getEventManager();
    $am = new AuditManager($auditConfig);
    $am->registerEvents($evm);
</code>
