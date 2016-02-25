<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/02/26
 */

namespace AppBundle\Controller\Todo;

use AppBundle\Repository\TodoRepository;
use AppBundle\Search\TodoList;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactory;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 *
 * @Route("/search")
 */
class SearchController
{
    /**
     * @var Paginator
     * @DI\Inject("knp_paginator")
     */
    private $paginator;

    /**
     * @var FormFactory
     * @DI\Inject("form.factory")
     */
    private $formFactory;

    /**
     * @var TodoRepository
     * @DI\Inject("app.repository.todo")
     */
    private $todoRepository;


    /**
     * @Route()
     * @Method("GET")
     * @Template(":Todo/Search:index.html.twig")
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $search = new TodoList();
        $form = $this->formFactory->create('todo_list', $search);
        $form->handleRequest($request);

        /** @var SlidingPagination $pagination */
        $pagination = $this->paginator->paginate(
            $this->todoRepository->getPaginateQuery($search),
            (int)$request->get('page', 1),
            10,
            ['defaultSortFieldName' => 'a.id', 'defaultSortDirection' => 'desc']
        );

        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Template(":Todo/Search:box.html.twig")
     * @return array
     */
    public function boxAction(Request  $request)
    {
        $search = new TodoList();
        $form = $this->formFactory->create('todo_list', $search);
        $form->handleRequest($request);
        return [
            'form' => $form->createView()
        ];
    }
}