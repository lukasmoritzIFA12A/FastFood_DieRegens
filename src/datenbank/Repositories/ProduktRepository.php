<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Produkt.php';

use datenbank\Entitaeten\Produkt;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class ProduktRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'produkt';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Produkt::class);
    }

    public function getById(int $id): ?Produkt
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($icon_id, $titel, $beschreibung, $preis, $lagerbestand, $rabatt): Produkt
    {
        $object = R::dispense(self::TABLE_NAME);
        $produkt = new Produkt($object);

        $produkt->setIconId($icon_id);
        $produkt->setTitel($titel);
        $produkt->setBeschreibung($beschreibung);
        $produkt->setPreis($preis);
        $produkt->setLagerbestand($lagerbestand);
        $produkt->setRabatt($rabatt);

        $id = R::store($produkt->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $icon_id, $titel, $beschreibung, $preis, $lagerbestand, $rabatt): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Produkt)
        {
            $object->setIconId($icon_id);
            $object->setTitel($titel);
            $object->setBeschreibung($beschreibung);
            $object->setPreis($preis);
            $object->setLagerbestand($lagerbestand);
            $object->setRabatt($rabatt);
            return R::store($object->getBean());
        }

        return null;
    }
}