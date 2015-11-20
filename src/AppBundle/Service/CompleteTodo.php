<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 3:00
 */

namespace AppBundle\Service;


use AppBundle\Entity\Todo;
use AppBundle\Specification\OpenTodoSpec;
use Doctrine\ORM\EntityManager;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\CommandUsecaseInterface;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class Done
 * @package AppBundle\Service
 *
 * @DI\Service()
 */
class CompleteTodo implements CommandUsecaseInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var OpenTodoSpec
     */
    private $specification;

    /**
     * Done constructor.
     * @param EntityManager $entityManager
     * @param OpenTodoSpec $specification
     *
     * @DI\InjectParams({
     *     "entityManager": @DI\Inject("doctrine.orm.entity_manager"),
     *     "specification": @DI\Inject("app_bundle.specification.open_todo_spec")
     * })
     */
    public function __construct(EntityManager $entityManager, OpenTodoSpec $specification)
    {
        $this->entityManager = $entityManager;
        $this->specification = $specification;
    }

    /**
     * @param EntityInterface $entity
     */
    public function run(EntityInterface $entity)
    {
        if (false === $this->specification->isSatisfiedBy($entity)) {
            throw new \InvalidArgumentException();
        }

        $entity->completed();
        $this->entityManager->flush();
    }

}