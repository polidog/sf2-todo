<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/23
 * Time: 18:34
 */

namespace AppBundle\Tests\Controller\Add;


use AppBundle\Controller\Todo\AddController;
use AppBundle\Entity\Todo;
use AppBundle\Service\AddTodo;
use AppBundle\Service\Notification;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Util\ControllerUnitTestCase;

use Phake;

/**
 * Class AddControllerTest
 * @package AppBundle\Tests\Controller\Add
 */
class AddControllerTest extends ControllerUnitTestCase
{
    /**
     * @test
     */
    public function タスク登録用のビューを表示する()
    {
        $properties = $this->getMockProperty();
        /** @var int $router */
        /** @var int $formFactory */
        /** @var int $addTodo */
        /** @var int $notification */
        extract($properties);

        $form = Phake::mock(Form::class);

        Phake::when($formFactory)->create('todo')
            ->thenReturn($form);



        /** @var AddController $controller */
        $controller = $this->createController(AddController::class, $properties);

        $controller->indexAction();

        Phake::verify($formFactory)->create('todo');
        Phake::verify($form)->createView();
        Phake::verify($router)->generate('app_todo_add_save');
    }

    /**
     * @test
     */
    public function バリデーションでエラーにならずTODOを保存できる()
    {
        $properties = $this->getMockProperty();
        /** @var int $router */
        /** @var int $formFactory */
        /** @var int $addTodo */
        /** @var int $notification */
        extract($properties);

        $form = Phake::mock(Form::class);
        $request = Phake::mock(Request::class);

        Phake::when($formFactory)->create('todo')
            ->thenReturn($form);

        Phake::when($form)->isValid()
            ->thenReturn(true);

        Phake::when($form)->getData()
            ->thenReturn(new Todo());

        Phake::when($router)->generate('app_todo_default_index')
            ->thenReturn('/');

        /** @var AddController $controller */
        $controller = $this->createController(AddController::class, $properties);

        $response = $controller->saveAction($request);

        Phake::verify($formFactory)->create('todo');
        Phake::verify($form)->handleRequest($request);
        Phake::verify($form)->isValid();
        Phake::verify($addTodo)->run($this->isInstanceOf(Todo::class));
        Phake::verify($notification)->info('タスクを登録しました');

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    private function getMockProperty()
    {
        return [
            'router' => Phake::mock(Router::class),
            'formFactory' => Phake::mock(FormFactory::class),
            'addTodo' => Phake::mock(AddTodo::class),
            'notification' => Phake::mock(Notification::class)
        ];
    }
}