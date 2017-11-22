<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


/**
 * Interface DataFetcherInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 */
interface DataFetcherInterface
{
    public function fetch(): DataFetcherResultInterface;
}