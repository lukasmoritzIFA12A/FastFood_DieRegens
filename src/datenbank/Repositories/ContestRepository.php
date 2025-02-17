<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Contest.php';

use datenbank\Entitaeten\Contest;

class ContestRepository
{
    private const TABLE_NAME = 'contest';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Contest::class);
    }

    public function getById(int $id): ?Contest
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($bild, $bestellung_id, $freigeschalten): Contest
    {
        $object = R::dispense(self::TABLE_NAME);
        $contest = new Contest($object);

        $contest->setBild($bild);
        $contest->setBestellungId($bestellung_id);
        $contest->setFreigeschalten($freigeschalten);

        $id = R::store($contest->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $bild, $bestellung_id, $freigeschalten): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Contest)
        {
            $object->setBild($bild);
            $object->setBestellungId($bestellung_id);
            $object->setFreigeschalten($freigeschalten);

            return R::store($object->getBean());
        }

        return null;
    }
}