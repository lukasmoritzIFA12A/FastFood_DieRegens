<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Rechnung.php';

use datenbank\Entitaeten\Rechnung;

class RechnungRepository
{
    private const TABLE_NAME = 'rechnung';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Rechnung::class);
    }

    public function getById(int $id): ?Rechnung
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($bestellung_id, $zahlungsdatum, $rabatt_id): Rechnung
    {
        $object = R::dispense(self::TABLE_NAME);
        $rechnung = new Rechnung($object);

        $rechnung->setBestellungId($bestellung_id);
        $rechnung->setZahlungsdatum($zahlungsdatum);
        $rechnung->setRabattId($rabatt_id);

        $id = R::store($rechnung->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $bestellung_id, $zahlungsdatum, $rabatt_id): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Rechnung)
        {
            $object->setBestellungId($bestellung_id);
            $object->setZahlungsdatum($zahlungsdatum);
            $object->setRabattId($rabatt_id);
            return R::store($object->getBean());
        }

        return null;
    }
}