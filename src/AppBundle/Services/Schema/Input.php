<?php
declare(strict_types=1);


namespace AppBundle\Services\Schema;


use AppBundle\Services\Schema\Exceptions\EmptyCompetitorUrlsException;

class Input
{
    /**
     * @var Url
     */
    private $sourceUrl;


    /**
     * @var Url[]
     */
    private $competitorUrls;

    /**
     * Input constructor.
     * @param Url $sourceUrl
     */
    public function __construct(Url $sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    public function addCompetitorUrl(Url $url): Input
    {
        $this->competitorUrls[] = $url;

        return $this;
    }

    /**
     * @return Url
     */
    public function getSourceUrl(): Url
    {
        return $this->sourceUrl;
    }

    /**
     * @return array
     * @throws EmptyCompetitorUrlsException
     */
    public function getCompetitorUrls(): array
    {
        if (empty($this->competitorUrls)) {
            throw new EmptyCompetitorUrlsException('You have to set at least one competitor url');
        }

        return $this->competitorUrls;
    }


}