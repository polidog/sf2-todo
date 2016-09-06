<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 1:49
 */

namespace AppBundle\Controller\Todo;


use AppBundle\Repository\TodoRepository;
use AppBundle\Specification\CloseTodoSpec;
use AppBundle\Specification\OpenTodoSpec;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller\Todo
 *
 * @Route("/")
 */
class DefaultController
{
    /**
     * @var Paginator
     * @DI\Inject("knp_paginator")
     */
    private $paginator;

    /**
     * @var OpenTodoSpec
     * @DI\Inject("app_bundle.specification.open_todo_spec")
     */
    private $openSpecification;

    /**
     * @var CloseTodoSpec
     * @DI\Inject("app_bundle.specification.close_todo_spec")
     */
    private $closeSpecification;

    /**
     * @var TodoRepository
     * @DI\Inject("app.repository.todo")
     */
    private $todoRepository;

    /**
     * @Route()
     * @Method("GET")
     * @Template(":Todo/Default:index.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        // TODO: このダサいifなんとかしたい。。。
        $type = $request->get('type', 1);
        if ($type == 1) {
            $spec = $this->openSpecification;
        } elseif ($type == 2) {
            $spec = $this->closeSpecification;
        } else {
            $spec = null;
            $type = 3;
        }

        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate(
            $this->todoRepository->getPaginateQuery($spec),
            $request->getInt('page', 1),
            10,
            ['defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'desc']
        );
        return [
            'pagination' => $pagination,
            'type' => $type
        ];
    }
}
