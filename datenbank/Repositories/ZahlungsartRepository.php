<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Zahlungsart.php';

use Entitaeten\Zahlungsart;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use RepositoryAccess;

class ZahlungsartRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'zahlungsart';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Zahlungsart::class);
    }

    public function getById(int $id): ?Zahlungsart
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($art): Zahlungsart
    {
        $object = R::dispense(self::TABLE_NAME);
        $zahlungsart = new Zahlungsart($object);

        $zahlungsart->setArt($art);

        $id = R::store($zahlungsart->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $art): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Zahlungsart)
        {
            $object->setArt($art);
            return R::store($object->getBean());
        }

        return null;
    }
}