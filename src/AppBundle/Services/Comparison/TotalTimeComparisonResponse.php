<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison;


use AppBundle\Services\Comparison\Contracts\ComparisonResponseInterface;
use AppBundle\Services\Comparison\Exceptions\DefinedFasterResponses;
use AppBundle\Services\Comparison\Exceptions\DefinedSlowerResponses;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\DataFetcher\Response;

/**
 * Class TotalTimeComparisonResponse
 * @package AppBundle\Services\Comparison
 */
class TotalTimeComparisonResponse implements ComparisonResponseInterface
{

    /**
     * @var DataFetcherResultInterface
     */
    private $dataFetcherResult;

    /**
     * @var Response[]
     */
    private $slowerThan;

    /**
     * @var Response[]
     */
    private $fasterThan;

    /**
     * TotalTimeComparisonResponse constructor.
     * @param DataFetcherResultInterface $fetchedData
     */
    public function __construct(DataFetcherResultInterface $fetchedData)
    {
        $this->dataFetcherResult = $fetchedData;
    }

    /**
     * @return array
     */
    public function getArrayResponse(): array
    {
        $data['message'] = sprintf('Source is loaded faster than %d page/pages', \count($this->slowerThan));
        $data['source'] = $this->dataFetcherResult->getSourceResponse();

        if ($this->getSlowerThan()) {
            $data['slower'] = $this->getSlowerThan();
        }

        if ($this->getFasterThan()) {
            $data['faster'] = $this->getFasterThan();
        }

        return $data;
    }

    /**
     * @param array $slower
     * @throws DefinedSlowerResponses
     */
    public function setSlowerResponses(array $slower): void
    {
        if (isset($this->slowerThan)) {
            throw new DefinedSlowerResponses('Responses were already set');
        }

        $this->slowerThan = $slower;
    }

    /**
     * @param array $faster
     * @throws DefinedFasterResponses
     */
    public function setFasterResponses(array $faster): void
    {
        if (isset($this->fasterThan)) {
            throw new DefinedFasterResponses('Responses were already set');
        }

        $this->fasterThan = $faster;
    }

    /**
     * @return Response[]
     */
    public function getSlowerThan(): array
    {
        return $this->slowerThan;
    }

    /**
     * @return Response[]
     */
    public function getFasterThan(): array
    {
        return $this->fasterThan;
    }


}