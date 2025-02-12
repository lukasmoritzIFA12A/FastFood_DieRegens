<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryJOINAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Produkt_Zutat.php';

use Entitaeten\Produkt_Zutat;
use RedBeanPHP\R;
use RepositoryJOINAccess;

class ProduktZutatRepository extends RepositoryJOINAccess
{
    private const TABLE_NAME = 'produkt_zutat';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Produkt_Zutat::class);
    }

    function getByProduktIdAndZutatId(int $produkt_id, int $zutat_id): ?Produkt_Zutat
    {
        $bean = R::findOne(self::TABLE_NAME, 'produkt_id = ? AND zutat_id = ?', [$produkt_id, $zutat_id]);
        if (!$bean)
        {
            return null;
        }

        return new Produkt_Zutat($bean);
    }

    function getAllByProduktId(int $produkt_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'produkt_id = ?', [$produkt_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Produkt_Zutat($bean), $beans);
    }

    function getAllByZutatId(int $zutat_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'zutat_id = ?', [$zutat_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Produkt_Zutat($bean), $beans);
    }

    function updateAllByProduktId(int $produkt_id, int $zutat_id): ?array
    {
        $object = $this->getAllByProduktId($produkt_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Produkt_Zutat)
                {
                    $obj->setZutatId($zutat_id);
                }
            }

            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    function updateAllByZutatId(int $zutat_id, int $produkt_id): ?array
    {
        $object = $this->getAllByProduktId($zutat_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Produkt_Zutat)
                {
                    $obj->setProduktId($produkt_id);
                }
            }
            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    function insert(int $produkt_id, int $zutat_id): Produkt_Zutat
    {
        $object = R::dispense(self::TABLE_NAME);
        $produkt_zutat = new Produkt_Zutat($object);

        $produkt_zutat->setProduktId($produkt_id);
        $produkt_zutat->setZutatId($zutat_id);

        R::store($produkt_zutat->getBean());
        return $this->getByProduktIdAndZutatId($produkt_id, $zutat_id);
    }

    function deleteByProduktIdAndZutatId(int $produkt_id, int $zutat_id): ?int
    {
        $object = $this->getByProduktIdAndZutatId($produkt_id, $zutat_id);
        if ($object)
        {
            return R::trash($object->getBean());
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

    function deleteAllByZutatId(int $zutat_id): ?int
    {
        $object = $this->getAllByZutatId($zutat_id);
        if ($object)
        {
            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::trashAll($beans);
        }

        return null;
    }
}