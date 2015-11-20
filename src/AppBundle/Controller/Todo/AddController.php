<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 1:12
 */

namespace AppBundle\Controller\Todo;

use AppBundle\Service\AddTodo;
use AppBundle\Service\Notification;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

/**
 * Class AddController
 * @package AppBundle\Controller\Todo
 *
 * @Route("/todo/add")
 */
class AddController
{
    /**
     * @var Router
     * @DI\Inject("router")
     */
    private $router;

    /**
     * @var FormFactory
     * @DI\Inject("form.factory")
     */
    private $formFactory;

    /**
     * @var AddTodo
     * @DI\Inject("app_bundle.service.add_todo")
     */
    private $addTodo;

    /**
     * @var Notification
     * @DI\Inject("app_bundle.service.notification")
     */
    private $notification;


    /**
     * @Template(":Todo:form.html.twig")
     * @return array
     */
    public function indexAction()
    {

        $form = $this->formFactory->create('todo');
        return [
            'form' => $form->createView(),
            'title' => '新規作成',
            'url' => $this->router->generate('app_todo_add_save')
        ];
    }

    /**
     * @Route()
     * @Method("POST")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveAction(Request $request)
    {
        $form = $this->formFactory->create('todo');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->addTodo->run($form->getData());
            $this->notification->info('タスクを登録しました');
        } else {
            $this->notification->danger('タスクの登録に失敗しました');
        }

        return new RedirectResponse($this->router->generate('app_todo_default_index'));
    }
}