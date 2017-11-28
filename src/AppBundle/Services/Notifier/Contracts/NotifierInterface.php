<?php
declare(strict_types=1);


namespace AppBundle\Services\Notifier\Contracts;


use AppBundle\Services\Comparison\TotalTimeComparisonResponse;
use AppBundle\Services\Notifier\Actions\Contracts\ActionInterface;

/**
 * Interface NotifierInterface
 * @package AppBundle\Services\Notifier\Contracts
 */
interface NotifierInterface
{
    /**
     * @param ActionInterface $action
     */
    public function addAction(ActionInterface $action): void;

    /**
     * Notify all action objects (listeners)
     * @param TotalTimeComparisonResponse $response
     */
    public function notify(TotalTimeComparisonResponse $response): void;
}