<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryJOINAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Bestellung_Menue.php';

use datenbank\Entitaeten\Bestellung_Menue;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryJOINAccess;

class BestellungMenueRepository extends RepositoryJOINAccess
{
    private const TABLE_NAME = 'bestellung_menue';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Bestellung_Menue::class);
    }

    function getByBestellungIdAndMenueId(int $bestellung_id, int $menue_id): ?Bestellung_Menue
    {
        $bean = R::findOne(self::TABLE_NAME, 'bestellung_id = ? AND menue_id = ?', [$bestellung_id, $menue_id]);
        if (!$bean)
        {
            return null;
        }

        return new Bestellung_Menue($bean);
    }

    function getAllByBestellungId(int $bestellung_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'bestellung_id = ?', [$bestellung_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Bestellung_Menue($bean), $beans);
    }

    function getAllByMenueId(int $menue_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'menue_id = ?', [$menue_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Bestellung_Menue($bean), $beans);
    }

    function updateAllByBestellungId(int $bestellung_id, int $menue_id): ?array
    {
        $object = $this->getAllByBestellungId($bestellung_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Bestellung_Menue)
                {
                    $obj->setMenueId($menue_id);
                }
            }

            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    function updateAllByMenueId(int $menue_id, int $bestellung_id): ?array
    {
        $object = $this->getAllByMenueId($menue_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Bestellung_Menue)
                {
                    $obj->setBestellungId($bestellung_id);
                }
            }

            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    /**
     * @throws SQL
     */
    function insert(int $bestellung_id, int $menue_id): Bestellung_Menue
    {
        $object = R::dispense(self::TABLE_NAME);
        $bestellung_menue = new Bestellung_Menue($object);

        $bestellung_menue->setBestellungId($bestellung_id);
        $bestellung_menue->setMenueId($menue_id);

        R::store($bestellung_menue->getBean());
        return $this->getByBestellungIdAndMenueId($bestellung_id, $menue_id);
    }

    function deleteByBestellungIdAndMenueId(int $bestellung_id, int $menue_id): ?int
    {
        $object = $this->getByBestellungIdAndMenueId($bestellung_id, $menue_id);
        if ($object)
        {
            return R::trash($object->getBean());
        }

        return null;
    }

    function deleteAllByBestellungId(int $bestellung_id): ?int
    {
        $object = $this->getAllByBestellungId($bestellung_id);
        if ($object)
        {
            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::trashAll($beans);
        }

        return null;
    }

    function deleteAllByMenueId(int $menue_id): ?int
    {
        $object = $this->getAllByMenueId($menue_id);
        if ($object)
        {
            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::trashAll($beans);
        }

        return null;
    }
}