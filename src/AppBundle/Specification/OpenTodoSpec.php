<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:02
 */

namespace AppBundle\Specification;


use AppBundle\Criteria;
use AppBundle\Entity\Todo;
use AppBundle\Entity\TodoStatus;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;
use PHPMentors\DomainKata\Specification\SpecificationInterface;
use JMS\DiExtraBundle\Annotation as DI;


/**
 * Class OpenTodoSpec
 * @package AppBundle\Specification
 *
 * @DI\Service()
 */
class OpenTodoSpec implements SpecificationInterface, CriteriaBuilderInterface
{

    /**
     * @param Todo $entity
     */
    public function isSatisfiedBy(EntityInterface $entity)
    {
        assert($entity instanceof Todo);
        return !$entity->getStatus()->isCompleted();
    }

    public function build()
    {
        $criteria = new Criteria();

        $status = new TodoStatus();
        $criteria->andWhere(
            $criteria->expr()->eq('status.value', $status->getValue())
        );
        return $criteria;
    }


}