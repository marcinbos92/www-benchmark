<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


/**
 * Interface DataFetcherInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 */
interface DataFetcherInterface
{
    /**
     * @return DataFetcherResultInterface
     */
    public function fetch(): DataFetcherResultInterface;
}