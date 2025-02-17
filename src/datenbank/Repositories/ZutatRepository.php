<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Zutat.php';

use datenbank\Entitaeten\Zutat;

class ZutatRepository
{
    private const TABLE_NAME = 'zutat';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Zutat::class);
    }

    public function getById(int $id): ?Zutat
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($zutatname): Zutat
    {
        $object = R::dispense(self::TABLE_NAME);
        $zutat = new Zutat($object);

        $zutat->setZutatName($zutatname);

        $id = R::store($zutat->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $zutatname): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Zutat)
        {
            $object->setZutatName($zutatname);
            return R::store($object->getBean());
        }

        return null;
    }
}