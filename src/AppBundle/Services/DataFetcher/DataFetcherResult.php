<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\DataFetcher\Exceptions\DefinedSourceResponse;
use AppBundle\Services\DataFetcher\Exceptions\EmptyCompetitorsResponses;
use AppBundle\Services\DataFetcher\Exceptions\NotDefinedSourceResponse;

/**
 * Class DataFetcherResult
 * @package AppBundle\Services\DataFetcher
 */
final class DataFetcherResult implements DataFetcherResultInterface
{

    /**
     * @var Response
     */
    private $sourceResponse;

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

    /**
     * @param Response $response
     * @throws DefinedSourceResponse
     */
    public function addSourceResponse(Response $response): void
    {
        if ($this->sourceResponse instanceof Response) {
            throw new DefinedSourceResponse('Source response has been set');
        }

        $this->sourceResponse = $response;
    }

    /**
     * @return Response
     * @throws NotDefinedSourceResponse
     */
    public function getSourceResponse(): Response
    {
        if ($this->sourceResponse instanceof Response) {
            return $this->sourceResponse;
        }

        throw new NotDefinedSourceResponse('You have to set source response first.');
    }

}