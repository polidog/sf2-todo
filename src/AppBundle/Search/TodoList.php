<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/02/26
 */

namespace AppBundle\Search;


use AppBundle\Criteria;
use AppBundle\Entity\TodoStatus;
use PHPMentors\DomainKata\Repository\Operation\CriteriaBuilderInterface;

class TodoList implements CriteriaBuilderInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var TodoStatus
     */
    private $status;


    /**
     * 検索条件の生成
     * @return Criteria
     */
    public function build()
    {
        $criteria = new Criteria();

        // タイトル検索
        if (empty($this->title)) {
            $criteria->andWhere(
                $criteria->expr()
                    ->contains('title', $this->title)
            );
        }

        // ステータス検索
        if ($this->status instanceof TodoStatus) {
            $criteria->andWhere(
                $criteria->expr()
                    ->eq('status.value', $this->status->getValue())
            );
        }

        return $criteria;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return TodoStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param TodoStatus $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }


}