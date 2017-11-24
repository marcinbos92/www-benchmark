<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\DataFetcher\Exceptions\EmptyCompetitorsResponses;

/**
 * Class DataFetcherResult
 * @package AppBundle\Services\DataFetcher
 */
class DataFetcherResult implements DataFetcherResultInterface
{
    /**
     * @var Response[]
     */
    private $competitorsResponses;

    /**
     * @param Response $response
     * @return DataFetcherResultInterface
     */
    public function addCompetitorResponse(Response $response): DataFetcherResultInterface
    {
        $this->competitorsResponses[] = $response;

        return $this;
    }

    /**
     * @return array
     * @throws EmptyCompetitorsResponses
     */
    public function getCompetitorsResponses(): array
    {
        if (empty($this->competitorsResponses)) {
            throw new EmptyCompetitorsResponses('You have to add at least one Competitor Response');
        }

        return $this->competitorsResponses;
    }

}