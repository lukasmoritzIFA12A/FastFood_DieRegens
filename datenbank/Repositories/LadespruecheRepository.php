<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Ladesprueche;

class LadespruecheRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Ladesprueche
    {
        $sql = $this->getStatement()['SELECT_LADESPRUECHE_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

        if ($row = $result->fetch_assoc()) {
            return new Ladesprueche(
                $row['idLadesprueche'],
                $row['spruch'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_LADESPRUECHE'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Ladesprueche(
                $row['idLadesprueche'],
                $row['spruch'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}