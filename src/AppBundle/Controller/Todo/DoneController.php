<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:59
 */

namespace AppBundle\Controller\Todo;
use AppBundle\Entity\Todo;
use AppBundle\Service\CompleteTodo;
use AppBundle\Service\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Class DoneController
 * @package AppBundle\Controller\Todo
 * @Route("/{id}/done", requirements={"id": "\d+"})
 */
class DoneController
{
    /**
     * @var Router
     * @DI\Inject("router")
     */
    private $router;

    /**
     * @var CompleteTodo
     * @DI\Inject("app_bundle.service.complete_todo")
     */
    private $completeTodo;

    /**
     * @var Notification
     * @DI\Inject("app_bundle.service.notification")
     */
    private $notification;

    /**
     * @Route()
     * @Method("GET")
     *
     * @param Todo $todo
     * @return RedirectResponse
     */
    public function indexAction(Todo $todo)
    {
        try {
            $this->completeTodo->run($todo);
            $this->notification->info('タスクを完了にしました');
        } catch (\InvalidArgumentException $e) {
            $this->notification->danger('完了処理に失敗しました');
        }
        return new RedirectResponse($this->router->generate('app_todo_default_index'));
    }
}