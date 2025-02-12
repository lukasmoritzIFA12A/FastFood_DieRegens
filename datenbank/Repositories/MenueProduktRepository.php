<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryJOINAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Menue_Produkt.php';

use Entitaeten\Menue_Produkt;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use RepositoryJOINAccess;

class MenueProduktRepository extends RepositoryJOINAccess
{
    private const TABLE_NAME = 'menue_produkt';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Menue_Produkt::class);
    }

    function getByMenueIdAndProduktId(int $menue_id, int $produkt_id): ?Menue_Produkt
    {
        $bean = R::findOne(self::TABLE_NAME, 'menue_id = ? AND produkt_id = ?', [$menue_id, $produkt_id]);
        if (!$bean)
        {
            return null;
        }

        return new Menue_Produkt($bean);
    }

    function getAllByMenueId(int $menue_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'menue_id = ?', [$menue_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Menue_Produkt($bean), $beans);
    }

    function getAllByProduktId(int $produkt_id): ?array
    {
        $beans = R::findAll(self::TABLE_NAME, 'produkt_id = ?', [$produkt_id]);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new Menue_Produkt($bean), $beans);
    }

    function updateAllByMenueId(int $menue_id, int $produkt_id): ?array
    {
        $object = $this->getAllByMenueId($menue_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Menue_Produkt)
                {
                    $obj->setProduktId($produkt_id);
                }
            }

            $beans = array_map(fn($obj) => $obj->getBean(), $object);
            return R::storeAll($beans);
        }

        return null;
    }

    function updateAllByProduktId(int $produkt_id, int $menue_id): ?array
    {
        $object = $this->getAllByProduktId($produkt_id);
        if ($object)
        {
            foreach ($object as $obj)
            {
                if ($obj instanceof Menue_Produkt)
                {
                    $obj->setMenueId($menue_id);
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
    function insert(int $menue_id, int $produkt_id): Menue_Produkt
    {
        $object = R::dispense(self::TABLE_NAME);
        $menue_produkt = new Menue_Produkt($object);

        $menue_produkt->setMenueId($menue_id);
        $menue_produkt->setProduktId($produkt_id);

        R::store($menue_produkt->getBean());
        return $this->getByMenueIdAndProduktId($menue_id, $produkt_id);
    }

    function deleteByMenueIdAndProduktId(int $menue_id, int $produkt_id): ?int
    {
        $object = $this->getByMenueIdAndProduktId($menue_id, $produkt_id);
        if ($object)
        {
            return R::trash($object->getBean());
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