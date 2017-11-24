<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


/**
 * Interface ResponseHeadersInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 * SOL[I]D
 */
interface ResponseHeadersInterface extends ResponseTimesInterface
{
    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return string
     */
    public function getContentType(): string;

    /**
     * @return int
     */
    public function getHeaderSize(): int;
}