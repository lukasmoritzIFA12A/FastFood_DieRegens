<?php

namespace src\datenbank\Repositories;

include_once dirname(__DIR__) . '/RepositoryAccess.php';
include_once dirname(__DIR__) . '/Entitaeten/Rating.php';

use datenbank\Entitaeten\Rating;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;
use src\datenbank\RepositoryAccess;

class RatingRepository extends RepositoryAccess
{
    private const TABLE_NAME = 'rating';

    function __construct()
    {
        parent::__construct(self::TABLE_NAME, Rating::class);
    }

    public function getById(int $id): ?Rating
    {
        return parent::getById($id);
    }

    /**
     * @throws SQL
     */
    function insert($kunde_id, $contest_id, $rating): Rating
    {
        $object = R::dispense(self::TABLE_NAME);
        $ratingObj = new Rating($object);

        $ratingObj->setKundeId($kunde_id);
        $ratingObj->setContestId($contest_id);
        $ratingObj->setRating($rating);

        $id = R::store($ratingObj->getBean());
        return $this->getById($id);
    }

    /**
     * @throws SQL
     */
    function update(int $id, $kunde_id, $contest_id, $rating): int|string|null
    {
        $object = $this->getById($id);
        if ($object instanceof Rating)
        {
            $object->setKundeId($kunde_id);
            $object->setContestId($contest_id);
            $object->setRating($rating);
            return R::store($object->getBean());
        }

        return null;
    }
}