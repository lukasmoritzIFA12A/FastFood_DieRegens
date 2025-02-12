<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Bestellung.php';

use Entitaeten\Bestellung;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use RepositoryAccess;

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
    function insert($bestellungdatum, $kunde_id, $zahlungsart_id, $produkt_id, $menue_id, $bestellstatus_id): Bestellung
    {
        $object = R::dispense(self::TABLE_NAME);
        $bestellung = new Bestellung($object);

        $bestellung->setBestellungdatum($bestellungdatum);
        $bestellung->setKundeId($kunde_id);
        $bestellung->setZahlungsartId($zahlungsart_id);
        $bestellung->setProduktId($produkt_id);
        $bestellung->setMenueId($menue_id);
        $bestellung->setBestellstatusId($bestellstatus_id);

        $id = R::store($bestellung->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $bestellungdatum, $kunde_id, $zahlungsart_id, $produkt_id, $menue_id, $bestellstatus_id): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Bestellung)
        {
            $object->setBestellungdatum($bestellungdatum);
            $object->setKundeId($kunde_id);
            $object->setZahlungsartId($zahlungsart_id);
            $object->setProduktId($produkt_id);
            $object->setMenueId($menue_id);
            $object->setBestellstatusId($bestellstatus_id);

            return R::store($object->getBean());
        }

        return null;
    }
}