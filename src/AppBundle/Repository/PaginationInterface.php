<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:13
 */

namespace AppBundle\Repository;


use PHPMentors\DomainKata\Entity\CriteriaInterface;

interface PaginationInterface
{
    public function getPaginateQuery(CriteriaInterface $criteria = null, $alias = 'a');
}