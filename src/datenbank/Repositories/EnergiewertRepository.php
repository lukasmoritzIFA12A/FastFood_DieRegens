<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Energiewert.php';

use OLDENTITIES\Energiewert;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class EnergiewertRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'energiewert';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Energiewert::class);
    }

    public function getById(int $id): ?Energiewert
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($produkt_id, $portionsize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss): Energiewert
    {
        $object = R::dispense(self::TABLE_NAME);
        $energiewert = new Energiewert($object);

        $energiewert->setProduktId($produkt_id);
        $energiewert->setPortionSize($portionsize);
        $energiewert->setKalorien($kalorien);
        $energiewert->setFett($fett);
        $energiewert->setKohlenhydrate($kohlenhydrate);
        $energiewert->setZucker($zucker);
        $energiewert->setEiweiss($eiweiss);

        $id = R::store($energiewert->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $produkt_id, $portionsize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Energiewert)
        {
            $object->setProduktId($produkt_id);
            $object->setPortionSize($portionsize);
            $object->setKalorien($kalorien);
            $object->setFett($fett);
            $object->setKohlenhydrate($kohlenhydrate);
            $object->setZucker($zucker);
            $object->setEiweiss($eiweiss);

            return R::store($object->getBean());
        }

        return null;
    }
}