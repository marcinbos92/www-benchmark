<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison\Contracts;


/**
 * Interface DataCompareInterface
 * @package AppBundle\Services\Comparison\Contracts
 */
interface DataCompareInterface
{
    /**
     * @return mixed
     */
    public function compare();
}