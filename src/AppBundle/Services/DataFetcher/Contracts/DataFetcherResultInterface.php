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
//    public function getNameLookUp(): string;
//    public function getConnect(): string;
//    public function getAppConnect(): string;
//    public function getPreTransfer(): string;
//    public function getRedirect(): string;
//    public function getStartTransfer(): string;
//    public function getTotal(): string;
}