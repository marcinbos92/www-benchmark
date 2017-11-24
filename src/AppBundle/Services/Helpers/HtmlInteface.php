<?php
declare(strict_types=1);


namespace AppBundle\Services\Helpers;


/**
 * Interface HtmlInteface
 * @package AppBundle\Services\Helpers
 */
interface HtmlInteface
{
    /**
     * @return string
     */
    public function asString(): string;

    /**
     * @return \DOMDocument
     */
    public function asObject(): \DOMDocument;
}