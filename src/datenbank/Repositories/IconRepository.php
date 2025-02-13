<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Icon.php';

use datenbank\Entitaeten\Icon;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class IconRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'icon';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Icon::class);
    }

    public function getById(int $id): ?Icon
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($bildpfad): Icon
    {
        $object = R::dispense(self::TABLE_NAME);
        $icon = new Icon($object);

        $icon->setBildPfad($bildpfad);

        $id = R::store($icon->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $bildpfad): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Icon)
        {
            $object->setBildPfad($bildpfad);
            return R::store($object->getBean());
        }

        return null;
    }
}