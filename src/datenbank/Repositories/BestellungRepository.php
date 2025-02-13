<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Bestellung.php';

use datenbank\Entitaeten\Bestellung;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class BestellungRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'bestellung';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Bestellung::class);
    }

    public function getById(int $id): ?Bestellung
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($bestellungdatum, $kunde_id, $zahlungsart_id, $bestellstatus_id): Bestellung
    {
        $object = R::dispense(self::TABLE_NAME);
        $bestellung = new Bestellung($object);

        $bestellung->setBestellungdatum($bestellungdatum);
        $bestellung->setKundeId($kunde_id);
        $bestellung->setZahlungsartId($zahlungsart_id);
        $bestellung->setBestellstatusId($bestellstatus_id);

        $id = R::store($bestellung->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $bestellungdatum, $kunde_id, $zahlungsart_id, $bestellstatus_id): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Bestellung)
        {
            $object->setBestellungdatum($bestellungdatum);
            $object->setKundeId($kunde_id);
            $object->setZahlungsartId($zahlungsart_id);
            $object->setBestellstatusId($bestellstatus_id);

            return R::store($object->getBean());
        }

        return null;
    }
}