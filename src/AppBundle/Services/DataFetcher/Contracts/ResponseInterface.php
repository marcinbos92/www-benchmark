<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


use AppBundle\Services\Helpers\HtmlInteface;

/**
 * Interface ResponseInterface
 * @package AppBundle\Services\DataFetcher\Contracts
 */
interface ResponseInterface
{
    /**
     * @return HtmlInteface
     */
    public function getHTML(): HtmlInteface;

    /**
     * @return ResponseHeadersInterface
     */
    public function getInfo(): ResponseHeadersInterface;
}