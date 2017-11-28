<?php
declare(strict_types=1);


namespace AppBundle\Services\Notifier\Actions\Contracts;

use AppBundle\Services\Comparison\TotalTimeComparisonResponse;


/**
 * Interface ActionInterface
 * @package AppBundle\Services\Notifier\Actions\Contracts
 */
/**
 * Interface ActionInterface
 * @package AppBundle\Services\Notifier\Actions\Contracts
 */
interface ActionInterface
{

    /**
     * @param TotalTimeComparisonResponse $response
     */
    public function run(TotalTimeComparisonResponse $response): void;
}