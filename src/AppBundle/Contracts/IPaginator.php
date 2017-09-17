<?php

namespace AppBundle\Contracts;

interface IPaginator
{
    public function paginate();
    public function getNextPage();
    public function getPreviousPage();
}