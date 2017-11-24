<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;

use AppBundle\Services\DataFetcher\Response;


/**
 * Interface DataFetcherResultInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 */
interface DataFetcherResultInterface
{
    /**
     * @return Response[]
     */
    public function getCompetitorsResponses(): array;

    /**
     * @return Response
     */
    public function getSourceResponse(): Response;
}