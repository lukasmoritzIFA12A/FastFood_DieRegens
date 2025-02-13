<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Menue.php';

use datenbank\Entitaeten\Menue;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class MenueRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'menue';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Menue::class);
    }

    public function getById(int $id): ?Menue
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($titel, $beschreibung): Menue
    {
        $object = R::dispense(self::TABLE_NAME);
        $menue = new Menue($object);

        $menue->setTitel($titel);
        $menue->setBeschreibung($beschreibung);

        $id = R::store($menue->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $titel, $beschreibung): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Menue)
        {
            $object->setTitel($titel);
            $object->setBeschreibung($beschreibung);
            return R::store($object->getBean());
        }

        return null;
    }
}