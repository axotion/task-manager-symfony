<?php

namespace AppBundle\Services;

use Doctrine\Common\Proxy\Exception\UnexpectedValueException;

class Paginator
{

    private $page;
    private $limit;
    private $offset;
    private $results;
    private $repository;

    public function init($page, $limit, $repository, $order = "desc", $orderBy = 'id')
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->offset = ((int)$this->page - 1) * $this->limit;
        $this->repository = $repository;
        $this->results = $this->repository->findBy([], [$orderBy => $order], $this->limit, $this->offset);
    }

    public function paginate()
    {
        if($this->page >= 0) {
            return $this->results;
        }
        throw new UnexpectedValueException('Page number cannot be below 0');
    }
    
    public function getNextPage()
    {
        if(!empty($this->results) and count($this->results) == $this->limit) {
            return true;
        }
        return false;
    }
    
    public function getPreviousPage()
    {
        if($this->offset == 0)
        {
            return false;
        }
        return true;
    }
}