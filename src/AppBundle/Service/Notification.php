<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 3:07
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Session\Session;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class Notification
 * @package AppBundle\Service
 *
 * @DI\Service()
 */
class Notification
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Notification constructor.
     * @param Session $session
     *
     * @DI\InjectParams({
     *     "session": @DI\Inject("session")
     * })
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public function info($message)
    {
        $this->addMessage('info', $message);
    }

    public function danger($message)
    {
        $this->addMessage('danger', $message);
    }

    private function addMessage($type, $message)
    {
        $this->session->getFlashBag()->add($type, $message);
    }
}