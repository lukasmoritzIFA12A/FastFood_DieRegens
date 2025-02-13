<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Kunde.php';

use OLDENTITIES\Kunde;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class KundeRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'kunde';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Kunde::class);
    }

    public function getById(int $id): ?Kunde
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($adresse_id, $vorname, $nachname, $telefonnummer, $registierungsdatum, $login_id): Kunde
    {
        $object = R::dispense(self::TABLE_NAME);
        $kunde = new Kunde($object);

        $kunde->setAdresseId($adresse_id);
        $kunde->setVorname($vorname);
        $kunde->setNachname($nachname);
        $kunde->setTelefonnummer($telefonnummer);
        $kunde->setRegistrierungsdatum($registierungsdatum);
        $kunde->setLoginId($login_id);

        $id = R::store($kunde->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $adresse_id, $vorname, $nachname, $telefonnummer, $registierungsdatum, $login_id): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Kunde)
        {
            $object->setAdresseId($adresse_id);
            $object->setVorname($vorname);
            $object->setNachname($nachname);
            $object->setTelefonnummer($telefonnummer);
            $object->setRegistrierungsdatum($registierungsdatum);
            $object->setLoginId($login_id);
            return R::store($object->getBean());
        }

        return null;
    }
}