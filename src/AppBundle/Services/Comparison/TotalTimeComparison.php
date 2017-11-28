<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison;


use AppBundle\Services\Comparison\Contracts\ComparisonResponseInterface;
use AppBundle\Services\Comparison\Contracts\DataCompareInterface;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\Notifier\Contracts\NotifierInterface;

/**
 * Class TotalTimeComparison
 * @package AppBundle\Services\Comparison
 */
class TotalTimeComparison implements DataCompareInterface
{
    /**
     * @var DataFetcherResultInterface
     */
    private $result;
    /**
     * @var NotifierInterface
     */
    private $notifier;

    /**
     * TotalTimeComparison constructor.
     * @param DataFetcherResultInterface $result
     * @param NotifierInterface $notifier
     */
    public function __construct(DataFetcherResultInterface $result, NotifierInterface $notifier)
    {
        $this->result = $result;
        $this->notifier = $notifier;
    }

    /**
     * @return ComparisonResponseInterface
     */
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

        $this->notifier->notify($response);

        return $response;
    }

    /**
     * @return float
     */
    private function getSourceTotalTime(): float
    {
        return $this->result->getSourceResponse()->getInfo()->getTotalTime();
    }

    /**
     * @return DataFetcherResultInterface
     */
    public function getDataFetcherResult(): DataFetcherResultInterface
    {
        return $this->result;
    }

}