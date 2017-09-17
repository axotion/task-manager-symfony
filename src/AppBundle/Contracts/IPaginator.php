<?php
/**
 * Created by PhpStorm.
 * User: axotion
 * Date: 17.09.2017
 * Time: 23:45
 */

interface IPaginator
{
    public function paginate();
    public function getNextPage();
    public function getPreviousPage();
}