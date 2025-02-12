<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Admin.php';

use Entitaeten\Admin;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use RepositoryAccess;

class AdminRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'admin';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Admin::class);
    }

    public function getById(int $id): ?Admin
    {
        $bean = R::findOne(self::TABLE_NAME, 'login_id = ?', [$id]);
        if (!$bean)
        {
            return null;
        }

        return new Admin($bean);
    }

    /**
     * @throws SQL
     */
    function insert(int $login_id): Admin
    {
        $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (login_id) VALUES (?)';
        $result = R::exec($sql, [$login_id]);
        if ($result)
        {
            return $this->getById($login_id);
        }

        throw new SQL("SQL Error: Konnte Admin nicht erstellen.");
    }
}