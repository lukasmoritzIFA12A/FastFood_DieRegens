<?php

namespace Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Rabatt.php';

use Entitaeten\Rabatt;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use RepositoryAccess;

class RabattRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'rabatt';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Rabatt::class);
    }

    public function getById(int $id): ?Rabatt
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($code, $minderung): Rabatt
    {
        $object = R::dispense(self::TABLE_NAME);
        $rabatt = new Rabatt($object);

        $rabatt->setCode($code);
        $rabatt->setMinderung($minderung);

        $id = R::store($rabatt->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $code, $minderung): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Rabatt)
        {
            $object->setCode($code);
            $object->setMinderung($minderung);
            return R::store($object->getBean());
        }

        return null;
    }
}