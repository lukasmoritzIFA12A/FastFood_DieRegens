<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryJOINAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Bestellung_Produkt.php';

use OLDENTITIES\Bestellung_Produkt;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryJOINAccess;

class BestellungProduktRepository extends RepositoryJOINAccess
{
    private const TABLE_NAME = 'bestellung_produkt';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Bestellung_Produkt::class);
    }

    function getByBestellungIdAndProduktId(int $bestellung_id, int $produkt_id): ?Bestellung_Produkt
    {
        $bean = R::findOne(self::TABLE_NAME, 'bestellung_id = ? AND produkt_id = ?', [$bestellung_id, $produkt_id]);
        if (!$bean)
        {
            return null;
        }

        return new Bestellung_Produkt($bean);
    }

    function getAllByBestellungId(int $bestellung_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'bestellung_id = ?', [$bestellung_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Bestellung_Produkt($bean), $beans);
    }

    function getAllByProduktId(int $produkt_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'produkt_id = ?', [$produkt_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Bestellung_Produkt($bean), $beans);
    }

    function updateAllByBestellungId(int $bestellung_id, int $produkt_id): ?array
    {
        $object = $this->getAllByBestellungId($bestellung_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Bestellung_Produkt)
                {
                    $obj->setProduktId($produkt_id);
                }
            }

            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    function updateAllByProduktId(int $produkt_id, int $bestellung_id): ?array
    {
        $object = $this->getAllByProduktId($produkt_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Bestellung_Produkt)
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
    function insert(int $bestellung_id, int $produkt_id): Bestellung_Produkt
    {
        $object = R::dispense(self::TABLE_NAME);
        $bestellung_produkt = new Bestellung_Produkt($object);

        $bestellung_produkt->setBestellungId($bestellung_id);
        $bestellung_produkt->setProduktId($produkt_id);

        R::store($bestellung_produkt->getBean());
        return $this->getByBestellungIdAndProduktId($bestellung_id, $produkt_id);
    }

    function deleteByBestellungIdAndProduktId(int $bestellung_id, int $produkt_id): ?int
    {
        $object = $this->getByBestellungIdAndProduktId($bestellung_id, $produkt_id);
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

    function deleteAllByProduktId(int $produkt_id): ?int
    {
        $object = $this->getAllByProduktId($produkt_id);
        if ($object)
        {
            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::trashAll($beans);
        }

        return null;
    }
}