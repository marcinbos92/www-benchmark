<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\ResponseHeadersInterface;
use AppBundle\Services\DataFetcher\Contracts\ResponseInterface;
use AppBundle\Services\Helpers\HtmlInteface;

/**
 * Class Response
 * @package AppBundle\Services\DataFetcher
 */
class Response implements ResponseInterface
{

    /**
     * @var ResponseHeadersInterface
     */
    private $headers;
    /**
     * @var HtmlInteface
     */
    private $html;

    /**
     * Response constructor.
     * @param ResponseHeadersInterface $headers
     * @param HtmlInteface $html
     */
    public function __construct(ResponseHeadersInterface $headers, HtmlInteface $html)
    {
        $this->headers = $headers;
        $this->html = $html;
    }

    /**
     * @return HtmlInteface
     */
    public function getHTML(): HtmlInteface
    {
        return $this->html;
    }

    /**
     * @return ResponseHeadersInterface
     */
    public function getInfo(): ResponseHeadersInterface
    {
        return $this->headers;
    }

}