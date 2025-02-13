<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Admin.php';

use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Entitaeten\Admin;
use src\datenbank\RepositoryAccess;

class AdminRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'admin';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Admin::class);
    }

    public function getById(int $id): ?Admin
    {
        $bean = R::findOne(self::TABLE_NAME, 'Login_id = ?', [$id]);
        if (!$bean)
        {
            return null;
        }

        return new Admin($bean);
    }

    function getAll(): ?array
    {

    }

    /**
     * @throws SQL
     */
    function insert(int $login_id): Admin
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (Login_id) VALUES (?)';
        $result = R::exec($sql, [$login_id]);
        if ($result)
        {
            return $this->getById($login_id);
        }

        throw new SQL("SQL Error: Konnte Admin nicht erstellen.");
    }
}