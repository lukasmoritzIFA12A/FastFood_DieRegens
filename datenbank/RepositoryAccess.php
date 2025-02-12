<?php

use RedBeanPHP\R;

/**
 * @template T
 */
class RepositoryAccess
{
    /** @var class-string<T> */
    protected string $entitaetsKlasse;

    private string $tableName;

    function __construct(string $tableName, string $entitaetsKlasse)
    {
        $this->tableName = $tableName;
        $this->entitaetsKlasse = $entitaetsKlasse;
    }

    /**
     * @return T|null
     */
    function getById(int $id): ?EntitaetsBean
    {
        $bean = R::load($this->tableName, $id);

        if ($bean->getProperties()['id']) {
            return new $this->entitaetsKlasse($bean);
        }

        return null;
    }

    /**
     * @return array<T>|null
     */
    function getAll(): ?array
    {
        $beans = R::findAll($this->tableName);
        if (!$beans)
        {
            return null;
        }

        return array_map(fn ($bean) => new $this->entitaetsKlasse($bean), $beans);
    }

    function deleteById(int $id): ?int
    {
        $object = $this->getById($id);
        if ($object->getBean()) {
            return R::trash($object->getBean());
        }

        return null;
    }

    function deleteAll(): bool
    {
        return R::exec('DELETE FROM ' . $this->tableName);
    }
}