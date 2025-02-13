<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Bestellstatus.php';

use datenbank\Entitaeten\Bestellstatus;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class BestellstatusRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'bestellstatus';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Bestellstatus::class);
    }

    public function getById(int $id): ?Bestellstatus
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($status): Bestellstatus
    {
        $object = R::dispense(self::TABLE_NAME);
        $bestellstatus = new Bestellstatus($object);
        $bestellstatus->setStatus($status);

        $id = R::store($bestellstatus->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $status): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Bestellstatus)
        {
            $object->setStatus($status);
            return R::store($object->getBean());
        }

        return null;
    }
}