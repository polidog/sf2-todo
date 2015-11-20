<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 1:36
 */

namespace AppBundle\Service;


use AppBundle\Entity\Todo;
use AppBundle\Entity\TodoStatus;
use AppBundle\Repository\TodoRepository;
use Doctrine\ORM\EntityManager;
use PHPMentors\DomainKata\Entity\EntityInterface;
use PHPMentors\DomainKata\Usecase\CommandUsecaseInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class AddTodo
 * @package AppBundle\Service
 *
 * @DI\Service()
 */
class AddTodo implements CommandUsecaseInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TodoRepository
     */
    private $repository;

    /**
     * AddTodo constructor.
     * @param EntityManager $entityManager
     * @param TodoRepository $repository
     *
     * @DI\InjectParams({
     *     "entityManager": @DI\Inject("doctrine.orm.entity_manager"),
     *     "repository": @DI\Inject("app.repository.todo")
     * })
     */
    public function __construct(EntityManager $entityManager, TodoRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param Todo $entity
     */
    public function run(EntityInterface $entity)
    {
        assert($entity instanceof Todo);
        $entity->setStatus(new TodoStatus());

        $this->repository->add($entity);
        $this->entityManager->flush();

    }

}