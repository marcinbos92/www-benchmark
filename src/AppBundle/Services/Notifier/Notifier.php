<?php
declare(strict_types=1);


namespace AppBundle\Services\Notifier;


use AppBundle\Services\Comparison\TotalTimeComparisonResponse;
use AppBundle\Services\Notifier\Actions\Contracts\ActionInterface;
use AppBundle\Services\Notifier\Contracts\NotifierInterface;

/**
 * Class Notifier
 * @package AppBundle\Services\Notifier
 */
class Notifier implements NotifierInterface
{
    /**
     * @var ActionInterface[]
     */
    private $actions = [];

    /**
     * @inheritdoc
     */
    public function addAction(ActionInterface $action): void
    {
        $this->actions[] = $action;
    }

    /**
     * @inheritdoc
     */
    public function notify(TotalTimeComparisonResponse $response): void
    {
        /**
         * @var $action ActionInterface
         */
        foreach ($this->actions as $action) {
            $action->run($response);
        }
    }

}