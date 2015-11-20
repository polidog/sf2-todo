<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:12
 */

namespace AppBundle\Repository;


use Doctrine\ORM\QueryBuilder;
use PHPMentors\DomainKata\Entity\CriteriaInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

trait PaginationTrait
{
    /**
     * ページネーション用のDQLを作成する
     *
     * @param CriteriaInterface $criteria
     * @param string $alias
     *
     * @return \Doctrine\ORM\Query
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getPaginateQuery(CriteriaInterface $criteria = null, $alias = 'a')
    {
        if ($criteria instanceof CriteriaBuilderInterface) {
            $criteria = $criteria->build();
        }
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder($alias);
        if ($criteria) {
            $queryBuilder->addCriteria($criteria);
        }
        return $queryBuilder->getQuery();
    }
}