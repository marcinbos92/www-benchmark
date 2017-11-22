<?php
declare(strict_types=1);


namespace AppBundle\Services\Schema;


class Url
{
    /**
     * @var string
     */
    private $url;

    /**
     * Url constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        //TODO validate if correct URL
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


}