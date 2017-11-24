<?php
declare(strict_types=1);


namespace AppBundle\Services\Helpers;


/**
 * Class Html
 * @package AppBundle\Services\Helpers
 */
class Html implements HtmlInteface
{
    /**
     * @var string
     */
    private $incomingHtml;


    /**
     * Html constructor.
     * @param string $incomingHtml
     */
    public function __construct(string $incomingHtml)
    {
        $this->incomingHtml = $incomingHtml;
    }

    /**
     * @return string
     */
    public function asString(): string
    {
        return $this->incomingHtml;
    }

    /**
     * @return \DOMDocument
     */
    public function asObject(): \DOMDocument
    {
        $domDocument = new \DOMDocument('1.0');
        $domDocument->loadHTML($this->incomingHtml);

        return $domDocument;
    }

}