<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Adresse.php';

use datenbank\Entitaeten\Adresse;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class AdresseRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'adresse';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Adresse::class);
    }

    public function getById(int $id): ?Adresse
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($strassenname, $hausnummer, $zusatz, $plz, $stadt, $bundesland): Adresse
    {
        $object = R::dispense(self::TABLE_NAME);
        $adresse = new Adresse($object);
        $adresse->setStrassenname($strassenname);
        $adresse->setHausnummer($hausnummer);
        $adresse->setZusatz($zusatz);
        $adresse->setPLZ($plz);
        $adresse->setStadt($stadt);
        $adresse->setBundesland($bundesland);

        $id = R::store($adresse->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $strassenname, $hausnummer, $zusatz, $plz, $stadt, $bundesland): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Adresse)
        {
            $object->setStrassenname($strassenname);
            $object->setHausnummer($hausnummer);
            $object->setZusatz($zusatz);
            $object->setPLZ($plz);
            $object->setStadt($stadt);
            $object->setBundesland($bundesland);
            return R::store($object->getBean());
        }

        return null;
    }
}