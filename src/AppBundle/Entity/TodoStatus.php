<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 1:23
 */

namespace AppBundle\Entity;


use PHPMentors\DomainKata\Entity\SingleValueInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TodoStatus
 * @package AppBundle\Entity
 *
 * @ORM\Embeddable()
 */
class TodoStatus implements SingleValueInterface
{
    const INCOMPLETE = 1;
    const COMPLETE = 2;

    private static $names = [
        self::INCOMPLETE => '未完了',
        self::COMPLETE => '完了'
    ];

    /**
     * @var int
     * @ORM\Column(name="status",type="smallint")
     */
    private $value;

    public function __construct($value = self::INCOMPLETE)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (isset(self::$names[$this->value])) {
            return self::$names[$this->value];
        }
        return '';
    }

    public static function getNames()
    {
        return self::$names;
    }

    public function completed()
    {
        $this->value = self::COMPLETE;
    }

    public function isCompleted()
    {
        return $this->value === self::COMPLETE;
    }

}