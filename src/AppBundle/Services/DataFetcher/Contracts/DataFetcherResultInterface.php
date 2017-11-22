<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


/**
 * Interface DataFetcherResultInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 */
interface DataFetcherResultInterface
{
    public function getNameLookUp(): string;
    public function getConnect(): string;
    public function getAppConnect(): string;
    public function getPreTransfer(): string;
    public function getRedirect(): string;
    public function getStartTransfer(): string;
    public function getTotal(): string;
}