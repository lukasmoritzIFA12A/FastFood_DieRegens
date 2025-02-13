<?php

namespace src\datenbank;
use R;

/**
 * @template T
 */
class RepositoryJOINAccess
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
     * @return array<T>|null
     */
    function getAll(): ?array
    {
        $beans = R::findAll($this->tableName);
        if (!$beans) {
            return null;
        }

        return array_map(fn($bean) => new $this->entitaetsKlasse($bean), $beans);
    }

    function deleteAll(): bool
    {
        return R::wipe($this->tableName);
    }
}