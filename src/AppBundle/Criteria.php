<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2015/11/21
 * Time: 2:01
 */

namespace AppBundle;

use \Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use PHPMentors\DomainKata\Entity\CriteriaInterface;

class Criteria extends DoctrineCriteria implements CriteriaInterface
{

}