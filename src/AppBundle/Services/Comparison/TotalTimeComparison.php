<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison;


use AppBundle\Services\Comparison\Contracts\ComparisonResponseInterface;
use AppBundle\Services\Comparison\Contracts\DataCompareInterface;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;

class TotalTimeComparison implements DataCompareInterface
{
    /**
     * @var DataFetcherResultInterface
     */
    private $result;

    public function __construct(DataFetcherResultInterface $result)
    {
        $this->result = $result;
    }

    public function compare(): ComparisonResponseInterface
    {
        $sourceTotalTime = $this->getSourceTotalTime();
        $fasterThan = [];
        $slowerThan = [];

        foreach ($this->result->getCompetitorsResponses() as $competitorResponse) {
            $competitorTime  = $competitorResponse->getInfo()->getTotalTime();

            if ($sourceTotalTime > $competitorTime) {
                $fasterThan[] = $competitorResponse;
            } else {
                $slowerThan[] = $competitorResponse;
            }
        }


        $response = new TotalTimeComparisonResponse($this->result);

        $response->setFasterResponses($fasterThan);
        $response->setSlowerResponses($slowerThan);

        return $response;
    }

    private function getSourceTotalTime(): float
    {
        return $this->result->getSourceResponse()->getInfo()->getTotalTime();
    }

    public function getDataFetcherResult(): DataFetcherResultInterface
    {
        return $this->result;
    }

}