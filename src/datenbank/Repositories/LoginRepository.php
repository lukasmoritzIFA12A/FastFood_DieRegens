<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Login.php';

use datenbank\Entitaeten\Login;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class LoginRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'login';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Login::class);
    }

    public function getById(int $id): ?Login
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($nutzername, $passwort): ?Login
    {
        $object = R::dispense(self::TABLE_NAME);
        $login = new Login($object);

        $login->setNutzername($nutzername);
        $login->setPasswort($passwort);

        $id = R::store($login->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $nutzername, $passwort): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Login)
        {
            $object->setNutzername($nutzername);
            $object->setPasswort($passwort);
            return R::store($object->getBean());
        }

        return null;
    }
}