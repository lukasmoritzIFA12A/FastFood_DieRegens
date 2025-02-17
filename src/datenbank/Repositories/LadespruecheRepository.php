<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Ladesprueche.php';

use datenbank\Entitaeten\Ladesprueche;

class LadespruecheRepository
{
    private const TABLE_NAME = 'ladesprueche';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Ladesprueche::class);
    }

    public function getById(int $id): ?Ladesprueche
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($spruch): Ladesprueche
    {
        $object = R::dispense(self::TABLE_NAME);
        $ladesprueche = new Ladesprueche($object);

        $ladesprueche->setSpruch($spruch);

        $id = R::store($ladesprueche->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $spruch): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Ladesprueche)
        {
            $object->setSpruch($spruch);
            return R::store($object->getBean());
        }

        return null;
    }
}